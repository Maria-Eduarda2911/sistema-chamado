<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Notifications\NewTicketCreated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyTechniciansOfNewTicket implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TicketCreated $event): void
    {
        // Buscar todos os técnicos
        $technicians = User::technicians()->get();

        // Enviar notificação para todos os técnicos
        foreach ($technicians as $technician) {
            $technician->notify(new NewTicketCreated($event->ticket, $event->creator));
        }

        // Alternativa: usar Notification facade para envio em massa
        // Notification::send($technicians, new NewTicketCreated($event->ticket, $event->creator));
    }
}
