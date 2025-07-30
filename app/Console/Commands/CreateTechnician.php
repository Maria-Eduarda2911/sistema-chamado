<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTechnician extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'technician:create 
                            {email : O email do técnico}
                            {name? : O nome do técnico}
                            {--password= : A senha do técnico (opcional)}
                            {--admin : Marcar também como admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criar um novo técnico no sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->argument('name') ?? $this->ask('Nome do técnico');
        $password = $this->option('password') ?? $this->secret('Senha do técnico');
        $isAdmin = $this->option('admin');

        // Verificar se o usuário já existe
        $existingUser = User::where('email', $email)->first();
        
        if ($existingUser) {
            if ($this->confirm("Usuário com email {$email} já existe. Deseja atualizar como técnico?")) {
                $existingUser->update([
                    'is_technician' => true,
                    'is_admin' => $isAdmin || $existingUser->is_admin
                ]);
                
                $this->info("Usuário {$existingUser->name} atualizado como técnico!");
                return Command::SUCCESS;
            } else {
                $this->error('Operação cancelada.');
                return Command::FAILURE;
            }
        }

        // Criar novo usuário técnico
        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'is_technician' => true,
                'is_admin' => $isAdmin,
            ]);

            $this->info("Técnico criado com sucesso!");
            $this->table(
                ['ID', 'Nome', 'Email', 'Técnico', 'Admin'],
                [[$user->id, $user->name, $user->email, 'Sim', $user->is_admin ? 'Sim' : 'Não']]
            );

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Erro ao criar técnico: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
