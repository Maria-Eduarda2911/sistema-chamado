<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use App\Models\Ticket;
use Exception;

class RabbitMqListener extends Command
{
    protected $signature = 'rabbitmq:listen';
    protected $description = 'Escuta mensagens do RabbitMQ e cria tickets automaticamente';

    public function handle()
    {
        $host = env('RABBITMQ_HOST', 'rabbitmq');
        $port = env('RABBITMQ_PORT', 5672);
        $user = env('RABBITMQ_USER', 'new_user');
        $pass = env('RABBITMQ_PASSWORD', '12345678');
        $queue = env('RABBITMQ_QUEUE', 'tickets');

        $this->info("Conectando ao RabbitMQ em $host:$port, fila: $queue");

        $callback = function (AMQPMessage $msg) use (&$channel, $queue) {
            $this->info('Mensagem recebida: ' . $msg->body);
            try {
                $data = json_decode($msg->body, true);
                if (!$data) {
                    throw new Exception('JSON inválido');
                }
                $categoryId = 1;
                $userId = 1;
                $assignedTo = 1;
                $statusMap = [
                    'aberto' => 'open',
                    'em_andamento' => 'in_progress',
                    'fechado' => 'closed',
                ];
                $status = $data['status'] ?? 'open';
                $status = $statusMap[$status] ?? $status;
                $ticket = Ticket::create([
                    'title' => $data['title'] ?? 'Sem título',
                    'description' => $data['description'] ?? '',
                    'priority' => $data['priority'] ?? 'medium',
                    'status' => $status,
                    'user_id' => $userId,
                    'category_id' => $categoryId,
                    'assigned_to' => $assignedTo,
                ]);
                $this->info('Ticket criado: ' . $ticket->id);
                $channel->basic_ack($msg->get('delivery_tag'));
            } catch (Exception $e) {
                $this->error('Erro ao criar ticket: ' . $e->getMessage());
                $channel->basic_ack($msg->get('delivery_tag'));
            }
        };

        $this->info('Aguardando mensagens. Para sair pressione CTRL+C');

        while (true) {
            try {
                $connection = new AMQPStreamConnection(
                    $host, $port, $user, $pass, '/', false, 'AMQPLAIN', null, 'en_US', 3.0, 3.0, null, true, 30
                );
                $channel = $connection->channel();
                $channel->queue_declare($queue, false, true, false, false);
                $channel->basic_consume($queue, '', false, false, false, false, $callback);
                $this->info('Conectado ao RabbitMQ. Aguardando mensagens...');
                while (count($channel->callbacks)) {
                    try {
                        $channel->wait();
                    } catch (\PhpAmqpLib\Exception\AMQPTimeoutException $e) {
                        continue;
                    }
                }
                $channel->close();
                $connection->close();
            } catch (\PhpAmqpLib\Exception\AMQPRuntimeException $e) {
                $this->error('Erro de conexão com RabbitMQ: ' . $e->getMessage());
                $this->info('Tentando reconectar em 5 segundos...');
                sleep(5);
            } catch (\Exception $e) {
                $this->error('Erro inesperado: ' . $e->getMessage());
                $this->info('Tentando reconectar em 5 segundos...');
                sleep(5);
            }
        }
    }
}
