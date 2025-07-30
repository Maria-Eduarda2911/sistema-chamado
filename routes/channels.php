<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Canal público para todos os tickets
Broadcast::channel('tickets', function ($user) {
    return true; // Qualquer usuário autenticado pode ouvir
});

// Canal privado apenas para técnicos
Broadcast::channel('technicians', function ($user) {
    return $user->is_technician || $user->is_admin;
});

// Canal para notificações específicas do usuário
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
