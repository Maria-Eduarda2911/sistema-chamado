<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewTicketCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket;
    protected $creator;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket, User $creator)
    {
        $this->ticket = $ticket;
        $this->creator = $creator;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Novo Ticket Criado')
                    ->line('Um novo ticket foi criado no sistema.')
                    ->line('Título: ' . $this->ticket->title)
                    ->line('Prioridade: ' . $this->ticket->priority)
                    ->line('Criado por: ' . $this->creator->name)
                    ->action('Ver Ticket', url('/tickets/' . $this->ticket->id))
                    ->line('Obrigado por usar nosso sistema!');
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'ticket_title' => $this->ticket->title,
            'ticket_priority' => $this->ticket->priority,
            'creator_name' => $this->creator->name,
            'creator_id' => $this->creator->id,
            'message' => "Novo ticket criado: {$this->ticket->title}",
            'url' => "/tickets/{$this->ticket->id}"
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'ticket_id' => $this->ticket->id,
            'ticket_title' => $this->ticket->title,
            'ticket_priority' => $this->ticket->priority,
            'creator_name' => $this->creator->name,
            'message' => "Novo ticket criado: {$this->ticket->title}",
            'url' => "/tickets/{$this->ticket->id}",
            'created_at' => now()->toISOString()
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'ticket_title' => $this->ticket->title,
            'ticket_priority' => $this->ticket->priority,
            'creator_name' => $this->creator->name,
            'message' => "Novo ticket criado: {$this->ticket->title}",
            'url' => "/tickets/{$this->ticket->id}"
        ];
    }
}
