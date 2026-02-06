<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Painel Administrativo | Sistema de Chamados</title>

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

        .sidebar a:hover {
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

        /* Dashboard cards */
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .card {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .card h3 {
            margin: 0 0 8px;
            font-size: 16px;
            color: var(--muted);
            font-weight: 500;
        }

        .card p {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
        }

        /* Seção administrativa */
        .admin-actions {
            margin-top: 32px;
        }

        .admin-actions h2 {
            font-size: 18px;
            margin-bottom: 16px;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }

        .action-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
        }

        .action-card h4 {
            margin: 0 0 6px;
            font-size: 15px;
        }

        .action-card p {
            margin: 0 0 12px;
            font-size: 13px;
            color: var(--muted);
        }

        .action-card a {
            display: inline-block;
            font-size: 13px;
            padding: 8px 12px;
            border-radius: 6px;
            background: var(--primary);
            color: #fff;
            text-decoration: none;
        }

        .action-card a:hover {
            background: var(--primary-dark);
        }

        footer {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: var(--muted);
        }

        /* Responsividade */
        @media (max-width: 1024px) {
            .dashboard {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 16px;
            }

            .actions-grid {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 12px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 1000;
            }

            .sidebar h2 {
                font-size: 12px;
                padding: 16px 8px;
            }

            .sidebar a {
                padding: 12px 8px;
                font-size: 12px;
                text-align: center;
                justify-content: center;
            }

            .main {
                padding: 16px;
                margin-left: 60px;
            }

            .main header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .main header h1 {
                font-size: 20px;
            }

            .dashboard {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .card {
                padding: 16px;
            }

            .actions-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .action-card {
                padding: 16px;
            }

            .table-container {
                overflow-x: auto;
            }

            table {
                min-width: 600px;
            }

            .table-container th,
            .table-container td {
                padding: 8px 6px;
                font-size: 13px;
            }
        }

        @media (max-width: 480px) {
            .main {
                padding: 12px;
                margin-left: 60px;
            }

            .main header h1 {
                font-size: 18px;
            }

            .card h3 {
                font-size: 14px;
            }

            .card p {
                font-size: 24px;
            }

            .action-card h4 {
                font-size: 14px;
            }

            .action-card p {
                font-size: 12px;
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
        <a href="{{ route('adm.settings') }}">Configurações</a>
        <a href="{{ route('logout') }}" class="logout">Sair</a>
    </aside>

    <!-- Conteúdo principal -->
    <main class="main">
        <header>
            <div>
                <h1>Painel Administrativo</h1>
                <span>Controle geral do sistema</span>
            </div>
        </header>

        <!-- Dashboard -->
        <section class="dashboard">
            <div class="card">
                <h3>Total de Usuários</h3>
                <p>{{ $stats['total_users'] }}</p>
            </div>
            <div class="card">
                <h3>Chamados Abertos</h3>
                <p>{{ $stats['open_tickets'] }}</p>
            </div>
            <div class="card">
                <h3>Chamados Finalizados</h3>
                <p>{{ $stats['closed_tickets'] }}</p>
            </div>
            <!-- Novo card: mostra quantidade de chamados arquivados -->
            <!-- Ajuda no controle organizacional do sistema -->
            <div class="card">
                <h3>Chamados Arquivados</h3>
                <p>{{ $stats['archived_tickets'] }}</p>
            </div>
            <div class="card">
                <h3>Técnicos Ativos</h3>
                <p>{{ $stats['technicians'] }}</p>
            </div>
        </section>

        <!-- Chamados recentes -->
        <section class="admin-actions">
            <h2>Chamados Recentes</h2>
            <div class="card">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--muted);">ID</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--muted);">Título</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--muted);">Cliente</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--muted);">Status</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--muted);">Data</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--muted);">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTickets as $ticket)
                            <tr style="border-bottom: 1px solid #f3f4f6;">
                                <td style="padding: 12px;">#{{ $ticket->id }}</td>
                                <td style="padding: 12px; max-width: 200px; overflow: hidden; text-overflow: ellipsis;">{{ $ticket->title }}</td>
                                <td style="padding: 12px;">{{ $ticket->user->name }}</td>
                                <td style="padding: 12px;">
                                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;
                                        @if($ticket->status == 'aberto') background: #fef3c7; color: #92400e;
                                        @elseif($ticket->status == 'em_atendimento') background: #dbeafe; color: #1e40af;
                                        @else background: #d1fae5; color: #065f46; @endif">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </td>
                                <td style="padding: 12px;">{{ $ticket->created_at->format('d/m/Y') }}</td>
                                <td style="padding: 12px;">
                                    <a href="{{ route('adm.ticket.show', $ticket->id) }}" style="color: var(--primary); text-decoration: none; font-size: 14px;">Ver</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="padding: 24px; text-align: center; color: var(--muted);">Nenhum chamado encontrado.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <footer>
            © 2025 Sistema de Chamados — Painel Administrativo
        </footer>
    </main>

</body>
</html>
 