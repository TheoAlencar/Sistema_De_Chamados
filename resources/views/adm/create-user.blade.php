<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--
        CRIAR USUÁRIO - create-user.blade.php
        Formulário para criação de novo usuário no sistema
        Permite definir nome, CPF, email, senha e papel
        Validação em tempo real e feedback visual
    -->
    <title>Criar Usuário | Sistema de Chamados</title>

    <!-- Fonte -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --bg: #f3f4f6;
            --card-bg: #ffffff;
            --text: #111827;
            --muted: #6b7280;
            --danger: #dc2626;
            --success: #10b981;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', Arial, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: #111827;
            color: #fff;
            display: flex;
            flex-direction: column;
        }

        .sidebar h2 {
            padding: 20px;
            margin: 0;
            font-size: 18px;
            text-align: center;
            border-bottom: 1px solid #1f2937;
        }

        .sidebar a {
            padding: 14px 20px;
            color: #d1d5db;
            text-decoration: none;
            font-size: 14px;
            display: block;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .sidebar a:hover, .sidebar a.active {
            background: #1f2937;
            color: #fff;
        }

        .sidebar .logout {
            margin-top: auto;
            background: var(--danger);
            color: #fff;
            text-align: center;
        }

        .sidebar .logout:hover {
            background: #b91c1c;
        }

        /* Conteúdo principal */
        .main {
            flex: 1;
            padding: 24px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .form-container {
            background: var(--card-bg);
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 500px;
        }

        .form-container h1 {
            margin: 0 0 8px;
            font-size: 24px;
            text-align: center;
        }

        .form-container p {
            margin: 0 0 24px;
            text-align: center;
            color: var(--muted);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 6px;
            color: var(--text);
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-group input.error, .form-group select.error {
            border-color: var(--danger);
        }

        .error-message {
            color: var(--danger);
            font-size: 14px;
            margin-top: 4px;
            display: none;
        }

        .form-group.error .error-message {
            display: block;
        }

        .password-strength {
            margin-top: 8px;
            font-size: 12px;
        }

        .strength-weak { color: var(--danger); }
        .strength-medium { color: #f59e0b; }
        .strength-strong { color: var(--success); }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: background 0.2s ease;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: var(--text);
            border: 1px solid #d1d5db;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .form-actions .btn {
            flex: 1;
        }

        /* Alertas */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* Responsividade */
        @media (max-width: 1024px) {
            .sidebar {
                width: 200px;
            }

            .sidebar h2 {
                font-size: 14px;
                padding: 20px 16px;
            }

            .sidebar a {
                padding: 14px 16px;
                font-size: 14px;
            }

            .main {
                padding: 20px;
            }

            .form-container {
                max-width: 450px;
                padding: 28px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
                position: fixed;
                height: 100vh;
                z-index: 1000;
            }

            .sidebar h2 {
                font-size: 12px;
                padding: 16px 8px;
                writing-mode: vertical-rl;
                text-orientation: mixed;
                transform: rotate(180deg);
            }

            .sidebar a {
                padding: 12px 8px;
                font-size: 12px;
                text-align: center;
                display: flex;
                align-items: center;
                justify-content: center;
                white-space: nowrap;
            }

            .sidebar a:not(.logout)::after {
                content: attr(title);
                position: absolute;
                left: 60px;
                top: 50%;
                transform: translateY(-50%);
                background: var(--primary);
                color: white;
                padding: 8px 12px;
                border-radius: 4px;
                font-size: 12px;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s;
                white-space: nowrap;
            }

            .sidebar a:hover::after {
                opacity: 1;
            }

            .main {
                margin-left: 60px;
                padding: 16px;
            }

            .form-container {
                max-width: none;
                padding: 24px;
                margin: 0;
            }

            .form-container h1 {
                font-size: 20px;
            }

            .form-group input,
            .form-group select {
                font-size: 16px; /* Previne zoom no iOS */
            }

            .form-actions {
                flex-direction: column;
                gap: 12px;
            }

            .form-actions .btn {
                width: 100%;
            }

            .alert {
                font-size: 13px;
                padding: 10px 14px;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 50px;
            }

            .sidebar a:not(.logout)::after {
                left: 50px;
            }

            .main {
                margin-left: 50px;
                padding: 12px;
            }

            .form-container {
                padding: 20px;
            }

            .form-container h1 {
                font-size: 18px;
            }

            .form-container p {
                font-size: 14px;
            }

            .form-group {
                margin-bottom: 16px;
            }

            .form-group label {
                font-size: 13px;
            }

            .form-group input,
            .form-group select {
                padding: 10px 14px;
                font-size: 16px;
            }

            .password-strength {
                font-size: 11px;
            }

            .btn {
                padding: 10px 20px;
                font-size: 15px;
            }

            .alert {
                font-size: 12px;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <h2>Admin</h2>
        <a href="{{ route('adm.homepage') }}">Dashboard</a>
        <a href="{{ route('adm.users') }}" class="active">Usuários</a>
        <a href="{{ route('adm.tickets') }}">Chamados</a>
        <a href="#">Relatórios</a>
        <a href="#">Configurações</a>
        <a href="{{ route('logout') }}" class="logout">Sair</a>
    </aside>

    <!-- Conteúdo principal -->
    <main class="main">
        <div class="form-container">
            <h1>Criar Novo Usuário</h1>
            <p>Preencha os dados para criar um novo usuário no sistema.</p>

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('adm.users.store') }}" id="userForm">
                @csrf

                <div class="form-group">
                    <label for="name">Nome Completo *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="cpf">CPF *</label>
                    <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="usuario@email.com">
                </div>

                <div class="form-group">
                    <label for="password">Senha *</label>
                    <input type="password" id="password" name="password" required>
                    <div class="password-strength" id="passwordStrength"></div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Senha *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="form-group">
                    <label for="role">Papel *</label>
                    <select id="role" name="role" required>
                        <option value="">Selecione um papel</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-actions">
                    <a href="{{ route('adm.users') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Criar Usuário</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Máscara para CPF
        document.getElementById('cpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
                e.target.value = value;
            }
        });

        // Verificação de força da senha
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthIndicator = document.getElementById('passwordStrength');

            if (password.length === 0) {
                strengthIndicator.textContent = '';
                return;
            }

            let strength = 0;
            if (password.length >= 6) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            if (strength <= 2) {
                strengthIndicator.textContent = 'Senha fraca';
                strengthIndicator.className = 'password-strength strength-weak';
            } else if (strength <= 3) {
                strengthIndicator.textContent = 'Senha média';
                strengthIndicator.className = 'password-strength strength-medium';
            } else {
                strengthIndicator.textContent = 'Senha forte';
                strengthIndicator.className = 'password-strength strength-strong';
            }
        });

        // Validação em tempo real
        document.getElementById('userForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('As senhas não coincidem!');
                return;
            }

            if (password.length < 6) {
                e.preventDefault();
                alert('A senha deve ter pelo menos 6 caracteres!');
                return;
            }
        });
    </script>

</body>
</html>