<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Message::create([
            'message' => 'Olá, estou com problema no acesso ao sistema.',
            'ticket_id' => 1,
            'user_id' => 1,
        ]);

        \App\Models\Message::create([
            'message' => 'Olá! Vou verificar o seu acesso. Pode me informar qual navegador você está usando?',
            'ticket_id' => 1,
            'user_id' => 2,
        ]);

        \App\Models\Message::create([
            'message' => 'Estou usando o Chrome versão 120.',
            'ticket_id' => 1,
            'user_id' => 1,
        ]);

        \App\Models\Message::create([
            'message' => 'Identifiquei o problema. Era um bloqueio temporário. Já resolvi. Tente acessar novamente.',
            'ticket_id' => 1,
            'user_id' => 2,
        ]);
    }
}
