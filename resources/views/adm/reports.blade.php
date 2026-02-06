<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Relatórios | Sistema de Chamados</title>

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

        /* Cards de estatísticas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .stat-card h3 {
            margin: 0 0 8px;
            font-size: 14px;
            color: var(--muted);
            font-weight: 500;
        }

        .stat-card p {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            color: var(--primary);
        }

        /* Gráficos e relatórios */
        .reports-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 32px;
        }

        .report-card {
            background: var(--card-bg);
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
        }

        .report-card h3 {
            margin: 0 0 16px;
            font-size: 18px;
            color: var(--text);
        }

        .chart-placeholder {
            height: 200px;
            background: #f9fafb;
            border: 2px dashed #e5e7eb;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            font-size: 14px;
        }

        .priority-stats {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .priority-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .priority-item span:first-child {
            font-weight: 500;
        }

        .priority-item span:last-child {
            font-weight: 700;
            color: var(--primary);
        }

        footer {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: var(--muted);
        }

        /* Responsividade */
        @media (max-width: 1024px) {
            .reports-section {
                grid-template-columns: 1fr;
            }
        }

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

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }

            .stat-card {
                padding: 16px;
            }

            .stat-card p {
                font-size: 24px;
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
        <a href="{{ route('adm.reports') }}" class="active">Relatórios</a>
        <a href="{{ route('adm.settings') }}">Configurações</a>
        <a href="{{ route('logout') }}" class="logout">Sair</a>
    </aside>

    <!-- Conteúdo principal -->
    <main class="main">
        <header>
            <div>
                <h1>Relatórios do Sistema</h1>
                <span>Análise detalhada de estatísticas e métricas</span>
            </div>
        </header>

        <!-- Estatísticas principais -->
        <section class="stats-grid">
            <div class="stat-card">
                <h3>Total de Usuários</h3>
                <p>{{ $stats['total_users'] }}</p>
            </div>
            <div class="stat-card">
                <h3>Total de Chamados</h3>
                <p>{{ $stats['total_tickets'] }}</p>
            </div>
            <div class="stat-card">
                <h3>Chamados Abertos</h3>
                <p>{{ $stats['open_tickets'] }}</p>
            </div>
            <div class="stat-card">
                <h3>Chamados Finalizados</h3>
                <p>{{ $stats['closed_tickets'] }}</p>
            </div>
            <div class="stat-card">
                <h3>Chamados Arquivados</h3>
                <p>{{ $stats['archived_tickets'] }}</p>
            </div>
            <div class="stat-card">
                <h3>Técnicos Ativos</h3>
                <p>{{ $stats['technicians'] }}</p>
            </div>
        </section>

        <!-- Gráficos e análises -->
        <section class="reports-section">
            <div class="report-card">
                <h3>Chamados por Mês</h3>
                <div class="chart-placeholder">
                    📊 Gráfico de chamados criados nos últimos 12 meses
                    @if($monthlyTickets->count() > 0)
                        <br><small>Dados disponíveis para visualização</small>
                    @else
                        <br><small>Nenhum dado disponível</small>
                    @endif
                </div>
            </div>

            <div class="report-card">
                <h3>Chamados por Prioridade</h3>
                <div class="priority-stats">
                    @php
                        $priorities = ['baixa' => 'Baixa', 'media' => 'Média', 'alta' => 'Alta'];
                    @endphp
                    @foreach($priorities as $key => $label)
                    <div class="priority-item">
                        <span>{{ $label }}</span>
                        <span>{{ $ticketsByPriority[$key] ?? 0 }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Métricas adicionais -->
        <section class="reports-section">
            <div class="report-card">
                <h3>Tempo Médio de Resolução</h3>
                <div style="text-align: center; padding: 40px 0;">
                    @if($avgResolutionTime && $avgResolutionTime->avg_hours)
                        <p style="font-size: 36px; font-weight: 700; color: var(--primary); margin: 0;">
                            {{ number_format($avgResolutionTime->avg_hours, 1) }}h
                        </p>
                        <p style="color: var(--muted); margin: 8px 0 0;">Tempo médio para resolução</p>
                    @else
                        <p style="color: var(--muted); margin: 0;">Dados insuficientes</p>
                    @endif
                </div>
            </div>

            <div class="report-card">
                <h3>Distribuição de Usuários</h3>
                <div class="priority-stats">
                    <div class="priority-item">
                        <span>Administradores</span>
                        <span>{{ $stats['admins'] }}</span>
                    </div>
                    <div class="priority-item">
                        <span>Técnicos</span>
                        <span>{{ $stats['technicians'] }}</span>
                    </div>
                    <div class="priority-item">
                        <span>Clientes</span>
                        <span>{{ $stats['clients'] }}</span>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            © 2025 Sistema de Chamados — Relatórios Administrativos
        </footer>
    </main>

</body>
</html>