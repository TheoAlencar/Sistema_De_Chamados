<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DeepCopy\f001\A;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DeepCopy\f001\A;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * CONTROLLER DE LOGIN - LoginController.php
 * Gerencia autenticação de usuários no sistema
 * Suporta login com CPF e senha
 * Redireciona usuários para dashboards específicos por papel
 */
class LoginController extends Controller
{

    /**
     * PÁGINA INICIAL / REDIRECIONAMENTO
     * Verifica se usuário está logado e redireciona para dashboard correto
     * Baseado no papel do usuário: adm, cliente ou tecnico
     */
    public function index()
    {
        $user = Auth::user();

        if ($user) {
            if ($user->hasRole('adm')) {
                return redirect()->route('adm.homepage');
            }
             elseif ($user->hasRole('cliente')) {
                return redirect()->route('cliente.homepage');   
            } 
            elseif ($user->hasRole('tecnico')) {
                return redirect()->route('tecnico.homepage');   
            }
            dd('Role não reconhecida.');
        } else {
            return redirect()->route('login');
        }
    }
    /**
     * EXIBIR FORMULÁRIO DE LOGIN
     * Mostra a página de login (TelaLogin.blade.php)
     */
    public function login()
    {
        return view('TelaLogin');
    }

    /**
     * PROCESSAR LOGIN
     * Valida credenciais e faz login do usuário
     * Usa CPF como campo de autenticação principal
     */
    public function logar(Request $request)
    {
        $cpf = $request->input('cpf');

        // Aqui você pode adicionar a lógica de autenticação usando o CPF
        // Por exemplo, verificar o CPF no banco de dados

        $validation = $request->validate([
            'cpf' => 'required|string|size:14',
        ]);

        if (Auth::attempt([
            'password' => $request->input('password') ,
            'cpf' => $validation['cpf']])){
            $request->session()->regenerate();
        } else {
            return back()->withErrors([
                'cpf' => 'CPF inválido.',
            ])->onlyInput('cpf');
        }


        // Se a autenticação for bem-sucedida, redirecione para a página desejada
        return redirect()->route('home'); // Substitua 'home' pela rota desejada após o login
    }

    /**
     * FAZER LOGOUT
     * Desconecta o usuário e limpa a sessão
     * Redireciona para página inicial
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}