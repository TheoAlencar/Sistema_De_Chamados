<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * MIDDLEWARE CHECKROLE - CheckRole.php
 * Verifica se o usuário tem um papel específico antes de acessar uma rota
 * Usado para controle de acesso baseado em permissões
 * Bloqueia acesso com erro 403 se usuário não tiver o papel requerido
 */
class CheckRole
{
    /**
     * PROCESSAR REQUEST
     * Verifica se usuário está autenticado e tem o papel necessário
     * Parâmetro $role pode ser: 'adm', 'cliente', 'tecnico'
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Verifica se usuário existe e tem o papel requerido
        if (!$request->user() || !$request->user()->hasRole($role)) {
            abort(403, 'Acesso negado.');
        }

        return $next($request);
    }
}
