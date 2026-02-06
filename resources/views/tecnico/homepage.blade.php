<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Painel do Técnico | Sistema de Chamados</title>

    <!-- Fonte -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0369a1;
            --bg: #f3f4f6;
            --card-bg: #ffffff;
            --text: #111827;
            --muted: #6b7280;
            --success: #16a34a;
            --warning: #f59e0b;
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
            background: #0f172a;
            color: #fff;
            display: flex;
            flex-direction: column;
        }

        .sidebar h2 {
            padding: 20px;
            margin: 0;
            font-size: 18px;
            text-align: center;
            border-bottom: 1px solid #1e293b;
        }

        .sidebar a {
            padding: 14px 20px;
            color: #cbd5f5;
            text-decoration: none;
            font-size: 14px;
            display: block;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .sidebar a:hover {
            background: #1e293b;
            color: #fff;
        }

        .sidebar a.active {
            background: var(--primary);
            color: #fff;
        }

        .sidebar .logout {
            margin-top: auto;
            background: #dc2626;
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

        /* Dashboard */
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
            font-size: 15px;
            color: var(--muted);
            font-weight: 500;
        }

        .card p {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            color: var(--primary);
        }

        /* Lista de chamados */
        .tickets {
            margin-top: 32px;
        }

        .tickets h2 {
            font-size: 18px;
            margin-bottom: 16px;
        }

        .ticket-list {
            background: var(--card-bg);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
        }

        .ticket-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px;
            border-bottom: 1px solid #e5e7eb;
        }

        .ticket-item:last-child {
            border-bottom: none;
        }

        .ticket-info {
            font-size: 14px;
        }

        .ticket-info strong {
            display: block;
            font-size: 15px;
        }

        .ticket-status {
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 600;
        }

        .status-open {
            background: #fef3c7;
            color: #92400e;
        }

        .status-progress {
            background: #e0f2fe;
            color: #075985;
        }

        .status-done {
            background: #dcfce7;
            color: #166534;
        }

        footer {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: var(--muted);
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <h2>Técnico</h2>
        <a href="{{ route('tecnico.homepage') }}" class="{{ !$filter ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('tecnico.homepage', ['filter' => 'meus_chamados']) }}" class="{{ $filter === 'meus_chamados' ? 'active' : '' }}">Meus Chamados</a>
        <a href="{{ route('tecnico.homepage', ['filter' => 'em_atendimento']) }}" class="{{ $filter === 'em_atendimento' ? 'active' : '' }}">Em Atendimento</a>
        <a href="{{ route('tecnico.homepage', ['filter' => 'finalizados']) }}" class="{{ $filter === 'finalizados' ? 'active' : '' }}">Finalizados</a>
        <a href="{{ route('logout') }}" class="logout">Sair</a>
    </aside>

    <!-- Conteúdo principal -->
    <main class="main">
        <header>
            <div>
                <h1>Painel do Técnico</h1>
                <span>Acompanhe e gerencie seus atendimentos</span>
            </div>
        </header>

        <!-- Cards -->
        <section class="dashboard">
            <div class="card">
                <h3>Chamados Atribuídos</h3>
                <p>{{ $assignedTickets->count() }}</p>
            </div>
            <div class="card">
                <h3>Em Atendimento</h3>
                <p>{{ $assignedTickets->where('status', 'em_atendimento')->count() }}</p>
            </div>
            <div class="card">
                <h3>Finalizados</h3>
                <p>{{ $assignedTickets->where('status', 'finalizado')->count() }}</p>
            </div>
        </section>

        <!-- Chamados atribuídos -->
        <section class="tickets">
            <h2>
                @if($filter === 'meus_chamados')
                    Meus Chamados
                @elseif($filter === 'em_atendimento')
                    Chamados Em Atendimento
                @elseif($filter === 'finalizados')
                    Chamados Finalizados
                @else
                    Meus Chamados
                @endif
            </h2>
            <div class="ticket-list">
                @forelse($assignedTickets as $ticket)
                <div class="ticket-item">
                    <div class="ticket-info">
                        <strong>#{{ $ticket->id }} - {{ $ticket->title }}</strong>
                        Cliente: {{ $ticket->user->name }}
                        <br>
                        <small>Prioridade: {{ ucfirst($ticket->priority) }}</small>
                    </div>
                    <div>
                        <span class="ticket-status status-{{ str_replace('_', '', $ticket->status) }}">
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </span>
                        <br>
                        <a href="{{ route('tecnico.ticket.show', $ticket->id) }}" style="font-size: 12px; color: var(--primary); text-decoration: none;">Ver detalhes</a>
                    </div>
                </div>
                @empty
                <div class="ticket-item">
                    <div class="ticket-info">
                        <strong>
                            @if($filter === 'meus_chamados')
                                Nenhum chamado atribuído
                            @elseif($filter === 'em_atendimento')
                                Nenhum chamado em atendimento
                            @elseif($filter === 'finalizados')
                                Nenhum chamado finalizado
                            @else
                                Nenhum chamado atribuído
                            @endif
                        </strong>
                    </div>
                </div>
                @endforelse
            </div>
        </section>

        <!-- Chamados disponíveis -->
        @if(!$filter && $availableTickets->count() > 0)
        <section class="tickets">
            <h2>Chamados Disponíveis</h2>
            <div class="ticket-list">
                @foreach($availableTickets as $ticket)
                <div class="ticket-item">
                    <div class="ticket-info">
                        <strong>#{{ $ticket->id }} - {{ $ticket->title }}</strong>
                        Cliente: {{ $ticket->user->name }}
                        <br>
                        <small>Prioridade: {{ ucfirst($ticket->priority) }} | Criado em: {{ $ticket->created_at->format('d/m/Y') }}</small>
                    </div>
                    <div>
                        <form action="{{ route('tecnico.ticket.assign', $ticket->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: var(--primary); color: white; border: none; padding: 6px 12px; border-radius: 4px; font-size: 12px; cursor: pointer;">Atribuir a mim</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <footer>
            © 2025 Sistema de Chamados — Painel do Técnico
        </footer>
    </main>

</body>
</html>