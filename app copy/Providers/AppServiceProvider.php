<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\{
    Icons\ChevronDown,
    Icons\UserCircle,
    Icons\Users,
    Icons\Ticket as IconTicket,
    Icons\Dashboard,
    Ticket
};

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Registro de serviços (se necessário)
    }

    public function boot(): void
    {
        // Registro de componentes Blade
        $this->registerBladeComponents();
    }

    protected function registerBladeComponents(): void
    {
        // Componentes com classes próprias
        Blade::component('icons.chevron-down', ChevronDown::class);
        Blade::component('ticket', Ticket::class);
        
        // Componentes inline
        Blade::component('icons.user-circle', UserCircle::class);
        Blade::component('icons.users', Users::class);
        Blade::component('icons.ticket', IconTicket::class);
        Blade::component('icons.dashboard', Dashboard::class);
    }
}