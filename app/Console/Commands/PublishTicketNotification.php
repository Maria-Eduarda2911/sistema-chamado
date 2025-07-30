<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use App\Models\Ticket;
use App\Models\User;
use Exception;

class PublishTicketNotification extends Command
{
    protected $signature = 'rabbitmq:publish-notification 
                            {--type=ticket_created : Tipo de notificação (ticket_created, ticket_updated, ticket_assigned)}
                            {--ticket-id= : ID do ticket (opcional, criará um novo se não fornecido)}
                            {--queue=ticket-notifications : Fila para publicar}';
                            
    protected $description = 'Publica uma mensagem de notificação de ticket no RabbitMQ';

    public function handle()
    {
        $type = $this->option('type');
        $ticketId = $this->option('ticket-id');
        $queue = $this->option('queue');

        $this->info("📤 Publicando notificação RabbitMQ...");
        $this->info("🏷️ Tipo: $type");
        $this->info("📫 Fila: $queue");

        try {
            if (!$ticketId) {
                $ticket = $this->createTestTicket();
                $ticketId = $ticket->id;
                $this->info("🎫 Ticket de teste criado com ID: $ticketId");
            } else {
                $ticket = Ticket::find($ticketId);
                if (!$ticket) {
                    $this->error("❌ Ticket com ID $ticketId não encontrado");
                    return Command::FAILURE;
                }
            }

            $messageData = $this->prepareMessageData($type, $ticket);

            $this->publishMessage($queue, $messageData);

            $this->info("✅ Notificação publicada com sucesso!");
            $this->line("📋 Dados enviados: " . json_encode($messageData, JSON_PRETTY_PRINT));

            return Command::SUCCESS;

        } catch (Exception $e) {
            $this->error("❌ Erro ao publicar notificação: " . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Cria um ticket de teste para demonstração
     * 
     * @return Ticket Ticket criado para teste
     */
    private function createTestTicket(): Ticket
    {
        $user = User::first();
        if (!$user) {
            throw new Exception('Nenhum usuário encontrado no sistema');
        }

        $category = \App\Models\Category::first();
        if (!$category) {
            $category = \App\Models\Category::create([
                'name' => 'Teste RabbitMQ',
                'description' => 'Categoria criada para teste de notificações'
            ]);
        }

        return Ticket::create([
            'title' => 'Ticket de Teste RabbitMQ - ' . now()->format('H:i:s'),
            'description' => 'Este é um ticket de teste criado para demonstrar notificações via RabbitMQ.',
            'priority' => 'alta',
            'status' => 'open',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
    }

    /**
     * Prepara os dados da mensagem baseado no tipo de notificação
     * 
     * @param string $type Tipo da notificação
     * @param Ticket $ticket Ticket relacionado à notificação
     * @return array Dados formatados para a mensagem
     */
    private function prepareMessageData(string $type, Ticket $ticket): array
    {
        $baseData = [
            'type' => $type,
            'ticket_id' => $ticket->id,
            'timestamp' => now()->toISOString(),
            'ticket' => [
                'id' => $ticket->id,
                'title' => $ticket->title,
                'description' => $ticket->description,
                'priority' => $ticket->priority,
                'status' => $ticket->status,
                'user_id' => $ticket->user_id,
                'category_id' => $ticket->category_id,
                'assigned_to' => $ticket->assigned_to,
                'created_at' => $ticket->created_at->toISOString(),
                'updated_at' => $ticket->updated_at->toISOString(),
            ]
        ];

        switch ($type) {
            case 'ticket_created':
                $creator = User::find($ticket->user_id);
                $baseData['creator'] = [
                    'id' => $creator->id,
                    'name' => $creator->name,
                    'email' => $creator->email,
                ];
                $baseData['message'] = "Novo ticket criado: {$ticket->title}";
                break;

            case 'ticket_updated':
                $baseData['message'] = "Ticket atualizado: {$ticket->title}";
                $baseData['changes'] = [
                    'status' => $ticket->status,
                    'priority' => $ticket->priority,
                ];
                break;

            case 'ticket_assigned':
                if ($ticket->assigned_to) {
                    $assignedUser = User::find($ticket->assigned_to);
                    $baseData['assigned_to'] = $ticket->assigned_to;
                    $baseData['assigned_user'] = [
                        'id' => $assignedUser->id,
                        'name' => $assignedUser->name,
                        'email' => $assignedUser->email,
                    ];
                    $baseData['message'] = "Ticket atribuído para: {$assignedUser->name}";
                } else {
                    $baseData['message'] = "Ticket desatribuído";
                }
                break;

            default:
                $baseData['message'] = "Evento de ticket: $type";
        }

        return $baseData;
    }

    /**
     * Publica mensagem na fila especificada do RabbitMQ
     * 
     * @param string $queue Nome da fila
     * @param array $data Dados a serem enviados
     */
    private function publishMessage(string $queue, array $data): void
    {
        $host = env('RABBITMQ_HOST', 'rabbitmq');
        $port = env('RABBITMQ_PORT', 5672);
        $user = env('RABBITMQ_USER', 'guest');
        $pass = env('RABBITMQ_PASSWORD', 'guest');

        $connection = new AMQPStreamConnection($host, $port, $user, $pass);
        $channel = $connection->channel();

        $channel->queue_declare($queue, false, true, false, false);

        $messageBody = json_encode($data);
        $message = new AMQPMessage($messageBody, [
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
            'timestamp' => time(),
            'content_type' => 'application/json',
        ]);

        $channel->basic_publish($message, '', $queue);

        $this->line("📤 Mensagem publicada na fila '$queue'");

        $channel->close();
        $connection->close();
    }
}
