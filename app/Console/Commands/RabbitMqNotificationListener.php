<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use App\Models\Ticket;
use App\Models\User;
use App\Events\TicketCreated;
use App\Notifications\NewTicketCreated;
use Exception;

class RabbitMqNotificationListener extends Command
{
    protected $signature = 'rabbitmq:listen-notifications {--queue=ticket-notifications}';
    protected $description = 'Escuta mensagens do RabbitMQ e envia notificações push para técnicos';

    private $connection = null;
    private $channel = null;

    public function handle()
    {
        $host = env('RABBITMQ_HOST', 'rabbitmq');
        $port = env('RABBITMQ_PORT', 5672);
        $user = env('RABBITMQ_USER', 'guest');
        $pass = env('RABBITMQ_PASSWORD', 'guest');
        $queue = $this->option('queue');

        $this->info("🔔 Iniciando listener de notificações RabbitMQ...");
        $this->info("📡 Conectando ao RabbitMQ em $host:$port");
        $this->info("📫 Fila: $queue");

        if (extension_loaded('pcntl')) {
            pcntl_signal(SIGTERM, [$this, 'shutdown']);
            pcntl_signal(SIGINT, [$this, 'shutdown']);
        }

        $maxRetries = 5;
        $retryCount = 0;

        while (true) {
            try {
                $this->closeConnections();

                $this->connection = new AMQPStreamConnection(
                    $host, 
                    $port, 
                    $user, 
                    $pass, 
                    '/', 
                    false, 
                    'AMQPLAIN', 
                    null, 
                    'en_US', 
                    10.0,
                    10.0,
                    null, 
                    true, 
                    60
                );

                $this->channel = $this->connection->channel();
                
                $this->channel->basic_qos(null, 1, null);
                
                $this->channel->queue_declare($queue, false, true, false, false);

                $this->info('✅ Conectado ao RabbitMQ. Aguardando mensagens de notificação...');
                $retryCount = 0;

                $callback = function (AMQPMessage $msg) use ($queue) {
                    $this->processNotificationMessage($msg);
                };

                $this->channel->basic_consume($queue, '', false, false, false, false, $callback);

                while ($this->channel && count($this->channel->callbacks)) {
                    try {
                        if (extension_loaded('pcntl')) {
                            pcntl_signal_dispatch();
                        }

                        $this->channel->wait(null, false, 5);
                        
                    } catch (\PhpAmqpLib\Exception\AMQPTimeoutException $e) {
                        continue;
                    } catch (\PhpAmqpLib\Exception\AMQPConnectionClosedException $e) {
                        $this->error('❌ Conexão fechada pelo servidor');
                        throw $e;
                    }
                }

            } catch (\PhpAmqpLib\Exception\AMQPRuntimeException $e) {
                $retryCount++;
                $this->error("❌ Erro de conexão com RabbitMQ (tentativa $retryCount/$maxRetries): " . $e->getMessage());
                
                $this->closeConnections();
                
                if ($retryCount >= $maxRetries) {
                    $this->error('💀 Número máximo de tentativas excedido. Saindo...');
                    break;
                }
                
                $waitTime = min(5 * $retryCount, 30);
                $this->info("⏳ Aguardando {$waitTime}s antes da próxima tentativa...");
                sleep($waitTime);
                
            } catch (Exception $e) {
                $this->error('💥 Erro inesperado: ' . $e->getMessage());
                $this->closeConnections();
                sleep(5);
            }
        }

        $this->closeConnections();
        $this->info('🔚 Listener de notificações encerrado.');
    }

    /**
     * Processa mensagem de notificação recebida do RabbitMQ
     * 
     * @param AMQPMessage $msg Mensagem AMQP recebida
     */
    private function processNotificationMessage(AMQPMessage $msg)
    {
        $this->info('📨 Mensagem de notificação recebida: ' . substr($msg->body, 0, 100) . '...');
        
        try {
            $data = json_decode($msg->body, true);
            
            if (!is_array($data)) {
                throw new Exception('JSON inválido na mensagem');
            }

            $requiredFields = ['type', 'ticket_id'];
            foreach ($requiredFields as $field) {
                if (!isset($data[$field])) {
                    throw new Exception("Campo obrigatório '$field' não encontrado");
                }
            }

            $type = $data['type'];
            $ticketId = $data['ticket_id'];

            $this->info("🎯 Processando notificação do tipo: $type para ticket ID: $ticketId");

            switch ($type) {
                case 'ticket_created':
                    $this->handleTicketCreatedNotification($data);
                    break;
                    
                case 'ticket_updated':
                    $this->handleTicketUpdatedNotification($data);
                    break;
                    
                case 'ticket_assigned':
                    $this->handleTicketAssignedNotification($data);
                    break;
                    
                default:
                    $this->warn("⚠️ Tipo de notificação desconhecido: $type");
            }

            $this->channel->basic_ack($msg->get('delivery_tag'));
            $this->info('✅ Mensagem processada com sucesso');

        } catch (Exception $e) {
            $this->error("❌ Erro ao processar mensagem de notificação: " . $e->getMessage());
            
            $this->channel->basic_ack($msg->get('delivery_tag'));
        }
    }

    /**
     * Processa notificação quando um ticket é criado
     * 
     * @param array $data Dados da mensagem contendo informações do ticket
     */
    private function handleTicketCreatedNotification(array $data)
    {
        $ticketId = $data['ticket_id'];
        $ticket = Ticket::find($ticketId);
        
        if (!$ticket) {
            throw new Exception("Ticket com ID $ticketId não encontrado");
        }

        $creator = User::find($ticket->user_id);
        if (!$creator) {
            throw new Exception("Usuário criador não encontrado");
        }

        $this->info("🎫 Enviando notificações para ticket: {$ticket->title}");

        $technicians = User::technicians()->get();
        $this->info("👥 Encontrados " . $technicians->count() . " técnicos");

        foreach ($technicians as $technician) {
            try {
                $technician->notify(new NewTicketCreated($ticket, $creator));
                $this->line("  📤 Notificação enviada para: {$technician->name}");
            } catch (Exception $e) {
                $this->error("  ❌ Falha ao notificar {$technician->name}: " . $e->getMessage());
            }
        }

        try {
            event(new TicketCreated($ticket, $creator));
            $this->info("📡 Evento de broadcasting disparado");
        } catch (Exception $e) {
            $this->error("❌ Falha no broadcasting: " . $e->getMessage());
        }
    }

    /**
     * Processa notificação quando um ticket é atualizado
     * 
     * @param array $data Dados da mensagem contendo informações do ticket
     */
    private function handleTicketUpdatedNotification(array $data)
    {
        $ticketId = $data['ticket_id'];
        $ticket = Ticket::find($ticketId);
        
        if (!$ticket) {
            throw new Exception("Ticket com ID $ticketId não encontrado");
        }

        $this->info("🔄 Ticket atualizado: {$ticket->title}");
        
        if ($ticket->assigned_to) {
            $assignedTechnician = User::find($ticket->assigned_to);
            if ($assignedTechnician) {
                $this->line("📤 Notificação de update enviada para: {$assignedTechnician->name}");
            }
        }
    }

    /**
     * Processa notificação quando um ticket é atribuído a um técnico
     * 
     * @param array $data Dados da mensagem contendo informações do ticket e usuário
     */
    private function handleTicketAssignedNotification(array $data)
    {
        $ticketId = $data['ticket_id'];
        $assignedUserId = $data['assigned_to'] ?? null;
        
        if (!$assignedUserId) {
            throw new Exception("ID do usuário atribuído não fornecido");
        }

        $ticket = Ticket::find($ticketId);
        $assignedUser = User::find($assignedUserId);
        
        if (!$ticket || !$assignedUser) {
            throw new Exception("Ticket ou usuário atribuído não encontrado");
        }

        $this->info("👤 Ticket atribuído para: {$assignedUser->name}");
        
        // $assignedUser->notify(new TicketAssignedNotification($ticket));
    }

    /**
     * Fecha as conexões ativas do RabbitMQ de forma segura
     */
    private function closeConnections()
    {
        try {
            if ($this->channel) {
                $this->channel->close();
                $this->channel = null;
            }
        } catch (Exception $e) {
            // Ignorar erros ao fechar canal
        }

        try {
            if ($this->connection) {
                $this->connection->close();
                $this->connection = null;
            }
        } catch (Exception $e) {
            // Ignorar erros ao fechar conexão
        }
    }

    /**
     * Manipula sinais de shutdown para encerramento gracioso
     */
    public function shutdown()
    {
        $this->info('🛑 Sinal de shutdown recebido. Fechando conexões...');
        $this->closeConnections();
        exit(0);
    }
}
