<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adiciona o status 'arquivado' ao enum de status da tabela tickets
     * Permite organizar chamados finalizados separadamente dos ativos
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Modifica o enum para incluir 'arquivado' como opção válida
            // Mantém valores existentes e adiciona o novo status
            $table->enum('status', ['aberto', 'em_atendimento', 'finalizado', 'arquivado'])->default('aberto')->change();
        });
    }

    /**
     * Reverse the migrations.
     * Remove o status 'arquivado' do enum, voltando ao estado anterior
     * Importante para rollback seguro da migração
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Reverte para os status originais, removendo 'arquivado'
            $table->enum('status', ['aberto', 'em_atendimento', 'finalizado'])->default('aberto')->change();
        });
    }
};
