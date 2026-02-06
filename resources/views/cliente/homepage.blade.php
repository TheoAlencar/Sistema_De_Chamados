<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Painel do Cliente | Sistema de Chamados</title>

    <!-- Fonte -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #22c55e;
            --primary-dark: #15803d;
            --bg: #f3f4f6;
            --card-bg: #ffffff;
            --text: #111827;
            --muted: #6b7280;
            --info: #0ea5e9;
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
            background: #052e16;
            color: #fff;
            display: flex;
            flex-direction: column;
        }

        .sidebar h2 {
            padding: 20px;
            margin: 0;
            font-size: 18px;
            text-align: center;
            border-bottom: 1px solid #064e3b;
        }

        .sidebar a {
            padding: 14px 20px;
            color: #d1fae5;
            text-decoration: none;
            font-size: 14px;
            display: block;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .sidebar a:hover {
            background: #064e3b;
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

        /* Chamados */
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
            padding: 16px 18px;
            border-bottom: 1px solid #e5e7eb;
        }

        .ticket-item:last-child {
            border-bottom: none;
        }

        .ticket-item strong {
            display: block;
            margin-bottom: 6px;
        }

        .ticket-status {
            display: inline-block;
            margin-top: 6px;
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 600;
            background: #e0f2fe;
            color: #075985;
        }

        .ticket-actions {
            margin-top: 10px;
        }

        .ticket-actions a {
            font-size: 13px;
            margin-right: 10px;
            color: var(--info);
            text-decoration: none;
        }

        .ticket-actions a:hover {
            text-decoration: underline;
        }

        /* Botão novo chamado */
        .new-ticket {
            margin-top: 32px;
            text-align: right;
        }

        .new-ticket a {
            background: var(--primary);
            color: #fff;
            padding: 12px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .new-ticket a:hover {
            background: var(--primary-dark);
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
        <h2>Cliente</h2>
        <a href="{{ route('cliente.homepage') }}" class="{{ !$filter ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('cliente.homepage', ['filter' => 'meus_chamados']) }}" class="{{ $filter === 'meus_chamados' ? 'active' : '' }}">Meus Chamados</a>
        <a href="{{ route('cliente.ticket.create') }}">Abrir Chamado</a>
        <a href="{{ route('cliente.homepage', ['filter' => 'chat_tecnico']) }}" class="{{ $filter === 'chat_tecnico' ? 'active' : '' }}">Chat com Técnico</a>
        <a href="{{ route('logout') }}" class="logout">Sair</a>
    </aside>

    <!-- Conteúdo principal -->
    <main class="main">
        <header>
            <div>
                <h1>Painel do Cliente</h1>
                <span>Acompanhe seus chamados e converse com o suporte</span>
            </div>
        </header>

        @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
        @endif

        <!-- Cards -->
        @if(!$filter)
        <section class="dashboard">
            <div class="card">
                <h3>Chamados Abertos</h3>
                <p>{{ $tickets->where('status', 'aberto')->count() }}</p>
            </div>
            <div class="card">
                <h3>Em Atendimento</h3>
                <p>{{ $tickets->where('status', 'em_atendimento')->count() }}</p>
            </div>
            <div class="card">
                <h3>Finalizados</h3>
                <p>{{ $tickets->where('status', 'finalizado')->count() }}</p>
            </div>
        </section>
        @endif

        <!-- Lista de chamados -->
        <section class="tickets">
            <h2>
                @if($filter === 'meus_chamados')
                    Meus Chamados
                @elseif($filter === 'chat_tecnico')
                    Chat com Técnico
                @else
                    Meus Chamados
                @endif
            </h2>
            <div class="ticket-list">
                @forelse($tickets as $ticket)
                <div class="ticket-item">
                    <strong>#{{ $ticket->id }} - {{ $ticket->title }}</strong>
                    Aberto em: {{ $ticket->created_at->format('d/m/Y') }}
                    <br />
                    <span class="ticket-status">{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</span>
                    <div class="ticket-actions">
                        <a href="{{ route('cliente.ticket.show', $ticket->id) }}">Ver detalhes</a>
                        @if($ticket->technician_id && $ticket->status !== 'finalizado')
                        <a href="{{ route('cliente.ticket.show', $ticket->id) }}#chat">Abrir chat</a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="ticket-item">
                    <strong>
                        @if($filter === 'meus_chamados')
                            Nenhum chamado encontrado
                        @elseif($filter === 'chat_tecnico')
                            Nenhum chamado ativo com técnico atribuído
                        @else
                            Nenhum chamado encontrado
                        @endif
                    </strong>
                </div>
                @endforelse
            </div>
        </section>

        <!-- Novo chamado -->
        @if(!$filter || $filter === 'meus_chamados')
        <div class="new-ticket">
            <a href="{{ route('cliente.ticket.create') }}">+ Abrir Novo Chamado</a>
        </div>
        @endif

        <footer>
            © 2025 Sistema de Chamados — Painel do Cliente
        </footer>
    </main>

</body>
</html>
