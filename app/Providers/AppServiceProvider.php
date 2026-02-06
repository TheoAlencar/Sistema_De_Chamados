<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * SERVICE PROVIDER PRINCIPAL - AppServiceProvider.php
 * Registra e inicializa serviços da aplicação Laravel
 * Executado durante o boot da aplicação
 * Usado para configurações globais e bindings de dependências
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * REGISTRAR SERVIÇOS
     * Chamado durante o registro de service providers
     * Usado para registrar bindings no container de injeção de dependência
     */
    public function register(): void
    {
        // Serviços são registrados aqui antes do boot
    }

    /**
     * INICIALIZAR SERVIÇOS
     * Chamado após todos os providers serem registrados
     * Usado para configurações que precisam de outros serviços já carregados
     */
    public function boot(): void
    {
        // Configurações de inicialização da aplicação
    }
}
