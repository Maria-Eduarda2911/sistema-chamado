<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        // Adicione outras políticas aqui
    ];

    /**
     * Register any authentication/authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Defina gates adicionais aqui (opcional)
        Gate::define('admin', function (User $user) {
            return $user->is_admin;
        });
    }
}