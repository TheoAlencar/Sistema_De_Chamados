<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\Permission\Traits\HasRoles;

/**
 * MODELO USER - USUÁRIO DO SISTEMA
 * Representa um usuário do sistema de chamados
 * Pode ser cliente, técnico ou administrador
 * Utiliza autenticação Laravel + permissões Spatie
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * CAMPOS QUE PODEM SER PREENCHIDOS EM MASSA
     * Define quais campos podem ser atribuídos diretamente
     * Importante para segurança - evita mass assignment
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'cpf',
        'password',
    ];

    /**
     * CAMPOS OCULTOS NA SERIALIZAÇÃO
     * Estes campos não aparecem em arrays/JSON
     * Protege dados sensíveis como senha
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * CONVERSÃO DE TIPOS DE DADOS
     * Define como os campos devem ser convertidos
     * email_verified_at vira DateTime, password é hasheado
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
