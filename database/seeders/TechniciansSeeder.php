<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TechniciansSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Criar alguns técnicos de exemplo
        $technicians = [
            [
                'name' => 'João Silva - Técnico',
                'email' => 'joao.tecnico@example.com',
                'password' => Hash::make('password'),
                'is_technician' => true,
                'is_admin' => false,
            ],
            [
                'name' => 'Maria Santos - Técnica',
                'email' => 'maria.tecnica@example.com',
                'password' => Hash::make('password'),
                'is_technician' => true,
                'is_admin' => false,
            ],
            [
                'name' => 'Carlos Lima - Técnico Senior',
                'email' => 'carlos.senior@example.com',
                'password' => Hash::make('password'),
                'is_technician' => true,
                'is_admin' => false,
            ],
        ];

        foreach ($technicians as $technicianData) {
            User::firstOrCreate(
                ['email' => $technicianData['email']],
                $technicianData
            );
        }

        // Atualizar usuários admin existentes para também serem técnicos
        User::where('is_admin', true)->update(['is_technician' => true]);
    }
}
