<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ticket;

class TicketPolicy
{
    public function view(User $user, Ticket $ticket)
    {
        return $user->is_admin || $ticket->user_id === $user->id;
    }

    public function create(User $user)
    {
        return true; // Todos usuários autenticados podem criar
    }

    public function update(User $user, Ticket $ticket)
    {
        return $user->is_admin || $ticket->user_id === $user->id;
    }

    public function delete(User $user, Ticket $ticket)
    {
        return $user->is_admin || $ticket->user_id === $user->id;
    }

    protected $policies = [
        Ticket::class => TicketPolicy::class,
    ];
    
}