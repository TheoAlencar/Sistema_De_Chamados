<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

/**
 * SEEDER DO BANCO DE DADOS - DatabaseSeeder.php
 * Popula o banco de dados com dados iniciais
 * Cria usuários de teste e dados necessários para desenvolvimento
 * Executado com: php artisan db:seed
 */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * EXECUTAR SEEDING
     * Popula o banco com dados iniciais
     * Cria usuário administrador para testes
     */
    public function run(): void
    {
        // Criar papéis se não existirem
        $adminRole = Role::firstOrCreate(['name' => 'adm']);
        $clienteRole = Role::firstOrCreate(['name' => 'cliente']);
        $tecnicoRole = Role::firstOrCreate(['name' => 'tecnico']);

        // Criar usuário administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@sistema.com',
            'cpf' => '000.000.000-00',
            'password' => Hash::make('admin123'),
        ]);
        $admin->assignRole('adm');

        // Criar técnicos
        $tecnico1 = User::create([
            'name' => 'João Silva',
            'email' => 'joao.tecnico@sistema.com',
            'cpf' => '111.111.111-11',
            'password' => Hash::make('123456'),
        ]);
        $tecnico1->assignRole('tecnico');

        $tecnico2 = User::create([
            'name' => 'Maria Santos',
            'email' => 'maria.tecnico@sistema.com',
            'cpf' => '222.222.222-22',
            'password' => Hash::make('123456'),
        ]);
        $tecnico2->assignRole('tecnico');

        // Criar clientes
        $cliente1 = User::create([
            'name' => 'Carlos Oliveira',
            'email' => 'carlos.cliente@sistema.com',
            'cpf' => '333.333.333-33',
            'password' => Hash::make('123456'),
        ]);
        $cliente1->assignRole('cliente');

        $cliente2 = User::create([
            'name' => 'Ana Pereira',
            'email' => 'ana.cliente@sistema.com',
            'cpf' => '444.444.444-44',
            'password' => Hash::make('123456'),
        ]);
        $cliente2->assignRole('cliente');

        // Criar chamados de exemplo
        Ticket::create([
            'title' => 'Problema com login',
            'description' => 'Não consigo fazer login no sistema. Aparece erro de senha inválida mesmo digitando corretamente.',
            'status' => 'aberto',
            'priority' => 'media',
            'user_id' => $cliente1->id,
        ]);

        Ticket::create([
            'title' => 'Sistema lento',
            'description' => 'O sistema está muito lento para carregar as páginas. Demora mais de 30 segundos para abrir qualquer tela.',
            'status' => 'em_atendimento',
            'priority' => 'alta',
            'user_id' => $cliente2->id,
            'technician_id' => $tecnico1->id,
        ]);

        Ticket::create([
            'title' => 'Erro ao salvar dados',
            'description' => 'Quando tento salvar um formulário, aparece mensagem de erro: "Campo obrigatório não preenchido".',
            'status' => 'finalizado',
            'priority' => 'baixa',
            'user_id' => $cliente1->id,
            'technician_id' => $tecnico2->id,
        ]);

        // Criar mensagens de exemplo
        Message::create([
            'message' => 'Olá! Pode me ajudar com o problema de login?',
            'ticket_id' => 1,
            'user_id' => $cliente1->id,
        ]);

        Message::create([
            'message' => 'Olá Carlos! Claro, vou verificar o que pode estar acontecendo. Você lembra se mudou a senha recentemente?',
            'ticket_id' => 1,
            'user_id' => $tecnico1->id,
        ]);

        Message::create([
            'message' => 'Oi João, obrigado pela resposta rápida! Sim, mudei a senha ontem. Será que tem algo relacionado?',
            'ticket_id' => 1,
            'user_id' => $cliente1->id,
        ]);
    }
}
