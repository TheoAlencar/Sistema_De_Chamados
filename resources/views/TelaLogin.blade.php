<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--
        TELA DE LOGIN - TelaLogin.blade.php
        Página de autenticação do sistema de chamados
        Permite que usuários façam login com email e senha
        Redireciona para dashboards específicos por papel (cliente/técnico/admin)
    -->
    <title>Login | Sistema de Chamados</title>

    <!-- Fonte moderna -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1e40af;
            --danger: #dc2626;
            --gray-100: #f3f4f6;
            --gray-300: #d1d5db;
            --gray-600: #4b5563;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', Arial, sans-serif;
            background: linear-gradient(135deg, #e5e7eb, #f9fafb);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 360px;
            background: #fff;
            padding: 32px 28px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .login-container h2 {
            margin: 0 0 8px;
            text-align: center;
            font-weight: 600;
        }

        .login-container p {
            margin: 0 0 24px;
            text-align: center;
            font-size: 14px;
            color: var(--gray-600);
        }

        .error-message {
            background: #fee2e2;
            color: var(--danger);
            padding: 10px 12px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 16px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid var(--gray-300);
            font-size: 14px;
            outline: none;
        }

        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
        }

        button {
            width: 100%;
            margin-top: 8px;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: var(--primary);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.05s ease;
        }

        button:hover {
            background: var(--primary-hover);
        }

        button:active {
            transform: scale(0.98);
        }

        .footer-links {
            margin-top: 16px;
            text-align: center;
            font-size: 13px;
        }

        .footer-links a {
            color: var(--primary);
            text-decoration: none;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Bem-vindo</h2>
        <p>Acesse o sistema com seu CPF</p>

        @error('cpf')
            <div class="error-message">
                {{ $message }}
            </div>
        @enderror

        <form action="{{ route('logar') }}" method="POST" novalidate>
            @csrf

            <div class="form-group">
                <label for="cpf">CPF</label>
                <input 
                    type="text" 
                    id="cpf" 
                    name="cpf" 
                    placeholder="000.000.000-00" 
                    required 
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Sua senha" 
                    required
                >
            </div>

            <button type="submit">Entrar</button>
        </form>

        <div class="footer-links">
            <a href="#">Esqueci minha senha</a>
        </div>
    </div>

    <!-- Máscara simples de CPF (opcional) -->
    <script>
        const cpfInput = document.getElementById('cpf');

        cpfInput.addEventListener('input', () => {
            let value = cpfInput.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            cpfInput.value = value;
        });
    </script>

</body>
</html>
