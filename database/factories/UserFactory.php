<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * FACTORY DE USUÁRIOS - UserFactory.php
 * Cria dados fictícios para testes e desenvolvimento
 * Gera usuários com dados aleatórios usando Faker
 * NOTA: Não inclui CPF pois deve ser único e específico
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Senha padrão usada pelo factory
     * Cacheada para performance em múltiplas criações
     */
    protected static ?string $password;

    /**
     * DEFINIÇÃO PADRÃO DO MODELO
     * Retorna array com dados padrão para criar usuário
     * Usa Faker para gerar dados realistas
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),                    // Nome aleatório
            'email' => fake()->unique()->safeEmail(),   // Email único e seguro
            'email_verified_at' => now(),                // Email já verificado
            'password' => static::$password ??= Hash::make('password'), // Senha padrão
            'remember_token' => Str::random(10),        // Token aleatório
            // CPF não incluído - deve ser definido manualmente para ser único
        ];
    }

    /**
     * ESTADO: EMAIL NÃO VERIFICADO
     * Modifica o factory para criar usuários com email não verificado
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,  // Remove verificação de email
        ]);
    }
}
