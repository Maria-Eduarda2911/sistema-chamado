<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Category;
use Exception;

class RabbitMqListener extends Command
{
    protected $signature = 'rabbitmq:listen';
    protected $description = 'Escuta mensagens do RabbitMQ e cria tickets automaticamente';

    private $connection = null;
    private $channel = null;

    public function handle()
    {
        $host = env('RABBITMQ_HOST', 'rabbitmq');
        $port = env('RABBITMQ_PORT', 5672);
        $user = env('RABBITMQ_USER', 'new_user');
        $pass = env('RABBITMQ_PASSWORD', '12345678');
        $queue = env('RABBITMQ_QUEUE', 'tickets');

        $this->info("Conectando ao RabbitMQ em $host:$port, fila: $queue");

        // Configurar handler para sinais (CTRL+C)
        if (extension_loaded('pcntl')) {
            pcntl_signal(SIGTERM, [$this, 'shutdown']);
            pcntl_signal(SIGINT, [$this, 'shutdown']);
        }

        $maxRetries = 5;
        $retryCount = 0;

        while (true) {
            try {
                // Fechar conexões anteriores se existirem
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

                $this->info('Conectado ao RabbitMQ. Aguardando mensagens...');
                $retryCount = 0;

                $callback = function (AMQPMessage $msg) use ($queue) {
                    $this->info('Mensagem recebida: ' . $msg->body);
                    try {
                        $data = json_decode($msg->body, true);
                        if (!is_array($data)) {
                            throw new Exception('JSON inválido');
                        }

                        $statusMap = [
                            'aberto' => 'open',
                            'em_andamento' => 'in_progress',
                            'fechado' => 'closed',
                        ];

                        $userId = $data['user_id'] ?? 1;
                        $categoryId = $data['category_id'] ?? 1;
                        $assignedTo = $data['assigned_to'] ?? 1;

                        if (!User::find($userId)) {
                            throw new Exception("Usuário com ID $userId não existe");
                        }
                        if (!User::find($assignedTo)) {
                            throw new Exception("Usuário atribuído com ID $assignedTo não existe");
                        }
                        if (!Category::find($categoryId)) {
                            throw new Exception("Categoria com ID $categoryId não existe");
                        }

                        $ticket = Ticket::create([
                            'title' => $data['title'] ?? 'Sem título',
                            'description' => $data['description'] ?? '',
                            'priority' => $data['priority'] ?? 'medium',
                            'status' => $statusMap[$data['status']] ?? ($data['status'] ?? 'open'),
                            'user_id' => $userId,
                            'category_id' => $categoryId,
                            'assigned_to' => $assignedTo,
                        ]);

                        $this->info("Ticket criado com sucesso! ID: {$ticket->id}");
                        
                        $this->channel->basic_ack($msg->get('delivery_tag'));

                    } catch (Exception $e) {
                        $this->error("Erro ao processar mensagem: " . $e->getMessage());
                        
                        $this->channel->basic_ack($msg->get('delivery_tag'));
                    }
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
                        $this->error('Conexão fechada pelo servidor');
                        throw $e;
                    }
                }

            } catch (\PhpAmqpLib\Exception\AMQPRuntimeException $e) {
                $retryCount++;
                $this->error("Erro de conexão com RabbitMQ (tentativa $retryCount/$maxRetries): " . $e->getMessage());
                
                $this->closeConnections();
                
                if ($retryCount >= $maxRetries) {
                    $this->error('Número máximo de tentativas excedido. Saindo...');
                    break;
                }
                
                $waitTime = min(5 * $retryCount, 30);
                $this->info("Tentando reconectar em $waitTime segundos...");
                sleep($waitTime);

            } catch (\Exception $e) {
                $retryCount++;
                $this->error("Erro inesperado (tentativa $retryCount/$maxRetries): " . $e->getMessage());
                
                $this->closeConnections();
                
                if ($retryCount >= $maxRetries) {
                    $this->error('Número máximo de tentativas excedido. Saindo...');
                    break;
                }
                
                $waitTime = min(5 * $retryCount, 30);
                $this->info("Tentando reconectar em $waitTime segundos...");
                sleep($waitTime);
            }
        }

        $this->closeConnections();
        $this->info('Listener finalizado.');
    }

    private function closeConnections()
    {
        try {
            if ($this->channel && $this->channel->is_open()) {
                $this->channel->close();
            }
        } catch (Exception $e) {
            // Ignorar erros ao fechar canal
        }

        try {
            if ($this->connection && $this->connection->isConnected()) {
                $this->connection->close();
            }
        } catch (Exception $e) {
            // Ignorar erros ao fechar conexão
        }

        $this->channel = null;
        $this->connection = null;
    }

    public function shutdown()
    {
        $this->info('Recebido sinal de parada. Finalizando...');
        $this->closeConnections();
        exit(0);
    }
}