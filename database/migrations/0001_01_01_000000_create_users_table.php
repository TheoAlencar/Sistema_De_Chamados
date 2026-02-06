<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * MIGRAÇÃO: CRIAR TABELA USERS
 * Cria a tabela principal de usuários do sistema
 * Inclui campos para autenticação Laravel padrão
 * Adiciona CPF único para identificação brasileira
 * Cria também tabelas auxiliares: password_reset_tokens e sessions
 */
return new class extends Migration
{
    /**
     * EXECUTAR MIGRAÇÃO (UP)
     * Cria as tabelas no banco de dados
     */
    public function up(): void
    {
        // TABELA PRINCIPAL DE USUÁRIOS
        Schema::create('users', function (Blueprint $table) {
            $table->id();                    // ID único auto-incremento
            $table->string('name');          // Nome completo do usuário
            $table->string('cpf')->unique(); // CPF único (obrigatório)
            $table->string('email')->nullable(); // Email opcional
            $table->timestamp('email_verified_at')->nullable(); // Verificação de email
            $table->string('password');      // Senha hasheada
            $table->rememberToken();         // Token para "lembrar-me"
            $table->timestamps();            // created_at e updated_at
        });

        // TABELA PARA RESET DE SENHA
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email como chave primária
            $table->string('token');            // Token de reset
            $table->timestamp('created_at')->nullable();
        });

        // TABELA PARA SESSÕES DO LARAVEL
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();     // ID da sessão
            $table->foreignId('user_id')->nullable()->index(); // ID do usuário (opcional)
            $table->string('ip_address', 45)->nullable();      // IP do usuário
            $table->text('user_agent')->nullable();             // User agent do navegador
            $table->longText('payload');                        // Dados da sessão
            $table->integer('last_activity')->index();          // Última atividade
        });
    }

    /**
     * REVERTER MIGRAÇÃO (DOWN)
     * Remove as tabelas criadas acima
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
