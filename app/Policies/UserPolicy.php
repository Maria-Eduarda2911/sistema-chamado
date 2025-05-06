<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determina se o usuário pode visualizar qualquer modelo.
     */
    public function viewAny(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Determina se o usuário pode criar modelos.
     */
    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Determina se o usuário pode atualizar o próprio perfil.
     */
    public function update(User $user, User $model): bool
    {
        // O próprio usuário ou admin pode atualizar
        return $user->id === $model->id || $user->is_admin;
    }

    /**
     * Determina se o usuário pode deletar usuários.
     */
    public function delete(User $user, User $model): bool
    {
        // Não pode deletar a si mesmo e precisa ser admin
        return $user->is_admin && $user->id !== $model->id;
    }

    /**
     * Verifica se o usuário tem privilégios de administrador
     */
    public function admin(User $user): bool
{
    return $user->is_admin ?? false;
}


    /**
     * Permite acesso total para administradores
     */
    public function before(User $user, string $ability)
{
    if ($user->is_admin) {
        return true; // Admins têm acesso total
    }
}
}