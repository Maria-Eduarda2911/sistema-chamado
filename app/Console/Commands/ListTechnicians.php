<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ListTechnicians extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'technician:list {--all : Mostrar todos os usuários}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listar todos os técnicos do sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $showAll = $this->option('all');
        
        if ($showAll) {
            $users = User::all();
            $this->info('Todos os usuários do sistema:');
        } else {
            $users = User::technicians()->get();
            $this->info('Técnicos cadastrados no sistema:');
        }

        if ($users->isEmpty()) {
            $this->warn('Nenhum usuário encontrado.');
            return Command::SUCCESS;
        }

        $tableData = $users->map(function ($user) {
            return [
                $user->id,
                $user->name,
                $user->email,
                $user->is_technician ? 'Sim' : 'Não',
                $user->is_admin ? 'Sim' : 'Não',
                $user->created_at->format('d/m/Y H:i')
            ];
        })->toArray();

        $this->table(
            ['ID', 'Nome', 'Email', 'Técnico', 'Admin', 'Criado em'],
            $tableData
        );

        $technicianCount = User::technicians()->count();
        $this->info("\nTotal de técnicos: {$technicianCount}");

        return Command::SUCCESS;
    }
}
