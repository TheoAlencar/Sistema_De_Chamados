<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Ticket::create([
            'title' => 'Problema no acesso',
            'description' => 'Estou enfrentando dificuldades para acessar o sistema. Quando tento fazer login, recebo uma mensagem de erro dizendo que minhas credenciais são inválidas, mesmo sabendo que estou usando a senha correta. Já tentei redefinir a senha, mas o problema persiste.',
            'status' => 'em_atendimento',
            'priority' => 'media',
            'user_id' => 1, // Assumindo que há um usuário com id 1
            'technician_id' => 2, // Assumindo que há um técnico com id 2
        ]);

        \App\Models\Ticket::create([
            'title' => 'Erro ao gerar relatório',
            'description' => 'Quando tento gerar o relatório mensal, o sistema apresenta um erro interno. O relatório não é gerado e aparece uma mensagem de erro genérica.',
            'status' => 'finalizado',
            'priority' => 'alta',
            'user_id' => 1,
            'technician_id' => 2,
        ]);
    }
}
