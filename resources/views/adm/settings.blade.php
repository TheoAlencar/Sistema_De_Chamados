<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Configurações | Sistema de Chamados</title>

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
            --success: #16a34a;
            --warning: #f59e0b;
            --danger: #dc2626;
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
            background: var(--primary);
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
        }

        .main header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .main header h1 {
            margin: 0;
            font-size: 22px;
        }

        .main header span {
            font-size: 14px;
            color: var(--muted);
        }

        /* Configurações */
        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 24px;
        }

        .settings-card {
            background: var(--card-bg);
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
        }

        .settings-card h3 {
            margin: 0 0 16px;
            font-size: 18px;
            color: var(--text);
            border-bottom: 2px solid var(--primary);
            padding-bottom: 8px;
        }

        .setting-item {
            margin-bottom: 20px;
            padding: 16px;
            background: #f9fafb;
            border-radius: 8px;
            border-left: 4px solid var(--primary);
        }

        .setting-item h4 {
            margin: 0 0 8px;
            font-size: 16px;
            color: var(--text);
        }

        .setting-item p {
            margin: 0 0 12px;
            color: var(--muted);
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: var(--text);
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
        }

        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn:hover {
            background: var(--primary-dark);
        }

        .btn:disabled {
            background: var(--muted);
            cursor: not-allowed;
        }

        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .status-active {
            background: var(--success);
        }

        .status-inactive {
            background: var(--muted);
        }

        .info-box {
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .info-box h4 {
            margin: 0 0 8px;
            color: #1e40af;
            font-size: 16px;
        }

        .info-box p {
            margin: 0;
            color: #3730a3;
            font-size: 14px;
        }

        footer {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: var(--muted);
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
            }

            .sidebar h2 {
                font-size: 12px;
                padding: 16px 8px;
            }

            .sidebar a {
                padding: 12px 8px;
                font-size: 12px;
                text-align: center;
            }

            .main {
                padding: 16px;
                margin-left: 60px;
            }

            .settings-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .settings-card {
                padding: 16px;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <h2>Admin</h2>
        <a href="{{ route('adm.homepage') }}">Dashboard</a>
        <a href="{{ route('adm.users') }}">Usuários</a>
        <a href="{{ route('adm.tickets') }}">Chamados</a>
        <a href="{{ route('adm.reports') }}">Relatórios</a>
        <a href="{{ route('adm.settings') }}" class="active">Configurações</a>
        <a href="{{ route('logout') }}" class="logout">Sair</a>
    </aside>

    <!-- Conteúdo principal -->
    <main class="main">
        <header>
            <div>
                <h1>Configurações do Sistema</h1>
                <span>Gerencie as configurações administrativas</span>
            </div>
        </header>

        @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
        @endif

        <!-- Informações do sistema -->
        <div class="info-box">
            <h4><span class="status-indicator status-active"></span>Sistema Ativo</h4>
            <p>Versão 1.0.0 - Sistema de Chamados IEMA</p>
        </div>

        <!-- Configurações -->
        <section class="settings-grid">
            <!-- Configurações Gerais -->
            <div class="settings-card">
                <h3>Configurações Gerais</h3>

                <div class="setting-item">
                    <h4>Nome do Sistema</h4>
                    <p>Configure o nome que aparecerá no sistema</p>
                    <form method="POST" action="#" style="display: inline;">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="system_name" value="Sistema de Chamados IEMA" placeholder="Nome do sistema" disabled>
                        </div>
                        <button type="submit" class="btn" disabled>Salvar</button>
                    </form>
                </div>

                <div class="setting-item">
                    <h4>Idioma Padrão</h4>
                    <p>Selecione o idioma padrão do sistema</p>
                    <form method="POST" action="#" style="display: inline;">
                        @csrf
                        <div class="form-group">
                            <select name="default_language" disabled>
                                <option value="pt-br" selected>Português (Brasil)</option>
                                <option value="en">English</option>
                                <option value="es">Español</option>
                            </select>
                        </div>
                        <button type="submit" class="btn" disabled>Salvar</button>
                    </form>
                </div>
            </div>

            <!-- Configurações de Email -->
            <div class="settings-card">
                <h3>Configurações de Email</h3>

                <div class="setting-item">
                    <h4>Servidor SMTP</h4>
                    <p>Configure o servidor de email para notificações</p>
                    <form method="POST" action="#" style="display: inline;">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="smtp_host" value="smtp.gmail.com" placeholder="Host SMTP" disabled>
                        </div>
                        <div class="form-group">
                            <input type="number" name="smtp_port" value="587" placeholder="Porta" disabled>
                        </div>
                        <button type="submit" class="btn" disabled>Salvar</button>
                    </form>
                </div>

                <div class="setting-item">
                    <h4>Notificações</h4>
                    <p>Configure quando enviar notificações por email</p>
                    <form method="POST" action="#" style="display: inline;">
                        @csrf
                        <div class="form-group">
                            <label><input type="checkbox" name="notify_new_ticket" checked disabled> Novo chamado criado</label>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="notify_status_change" checked disabled> Mudança de status</label>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="notify_assignment" checked disabled> Atribuição de técnico</label>
                        </div>
                        <button type="submit" class="btn" disabled>Salvar</button>
                    </form>
                </div>
            </div>

            <!-- Limites do Sistema -->
            <div class="settings-card">
                <h3>Limites do Sistema</h3>

                <div class="setting-item">
                    <h4>Limite de Chamados por Usuário</h4>
                    <p>Limite máximo de chamados abertos por cliente</p>
                    <form method="POST" action="#" style="display: inline;">
                        @csrf
                        <div class="form-group">
                            <input type="number" name="max_tickets_per_user" value="10" min="1" max="100" disabled>
                        </div>
                        <button type="submit" class="btn" disabled>Salvar</button>
                    </form>
                </div>

                <div class="setting-item">
                    <h4>Tamanho Máximo de Arquivos</h4>
                    <p>Tamanho máximo para anexos (em MB)</p>
                    <form method="POST" action="#" style="display: inline;">
                        @csrf
                        <div class="form-group">
                            <input type="number" name="max_file_size" value="10" min="1" max="50" disabled>
                        </div>
                        <button type="submit" class="btn" disabled>Salvar</button>
                    </form>
                </div>
            </div>

            <!-- Manutenção -->
            <div class="settings-card">
                <h3>Manutenção do Sistema</h3>

                <div class="setting-item">
                    <h4>Cache do Sistema</h4>
                    <p>Limpe o cache para melhorar performance</p>
                    <form method="POST" action="#" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn" style="background: var(--warning);" disabled>
                            Limpar Cache
                        </button>
                    </form>
                </div>

                <div class="setting-item">
                    <h4>Backup de Dados</h4>
                    <p>Faça backup regular dos dados do sistema</p>
                    <form method="POST" action="#" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn" style="background: var(--success);" disabled>
                            Fazer Backup
                        </button>
                    </form>
                </div>

                <div class="setting-item">
                    <h4>Modo de Manutenção</h4>
                    <p>Ative para impedir acesso temporário ao sistema</p>
                    <form method="POST" action="#" style="display: inline;">
                        @csrf
                        <div class="form-group">
                            <label><input type="checkbox" name="maintenance_mode" disabled> Ativar modo manutenção</label>
                        </div>
                        <button type="submit" class="btn" style="background: var(--danger);" disabled>
                            Aplicar
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <footer>
            © 2025 Sistema de Chamados — Configurações Administrativas
        </footer>
    </main>

</body>
</html>