<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as ModelsRole;

/**
 * MODELO ROLE - PERMISSÕES DO SISTEMA
 * Extende o modelo Role do Spatie Laravel Permission
 * Define os papéis dos usuários: cliente, técnico, admin
 * Gerencia permissões e controle de acesso
 */
class Role extends ModelsRole
{
    // Herda todas as funcionalidades do Spatie Permission
    // Permite criar papéis como: cliente, tecnico, administrador
}
