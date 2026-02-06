<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--
        DETALHES DO CHAMADO - ticket-detail.blade.php
        Página administrativa para visualizar detalhes completos de um chamado
        Permite alterar status, ver chat completo e gerenciar o chamado
        Interface completa para administração de chamados
    -->
    <title>Chamado #{{ $ticket->id }} | Sistema de Chamados</title>

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
            --warning: #f59e0b;
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

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.2s ease;
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

        .btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        /* Layout de duas colunas */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 24px;
        }

        /* Detalhes do chamado */
        .ticket-details {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .ticket-header {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }

        .ticket-title {
            font-size: 20px;
            font-weight: 600;
            margin: 0 0 8px;
        }

        .ticket-meta {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            font-size: 14px;
            color: var(--muted);
        }

        .ticket-description {
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .status-section, .assignment-section {
            margin-bottom: 24px;
            padding: 16px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .status-section h3, .assignment-section h3 {
            margin: 0 0 12px;
            font-size: 16px;
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
        }

        .status-aberto {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-em_atendimento {
            background: #fef3c7;
            color: #92400e;
        }

        .status-finalizado {
            background: #d1fae5;
            color: #065f46;
        }

        .priority-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .priority-baixa {
            background: #e5e7eb;
            color: #374151;
        }

        .priority-media {
            background: #fed7aa;
            color: #9a3412;
        }

        .priority-alta {
            background: #fecaca;
            color: #991b1b;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .form-group select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Chat */
        .chat-section {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            height: fit-content;
        }

        .chat-section h3 {
            margin: 0 0 16px;
            font-size: 18px;
        }

        .chat-messages {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 16px;
            padding-right: 8px;
        }

        .message {
            margin-bottom: 16px;
            padding: 12px;
            border-radius: 8px;
            background: #f9fafb;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-size: 12px;
            color: var(--muted);
        }

        .message-content {
            line-height: 1.5;
        }

        .no-messages {
            text-align: center;
            color: var(--muted);
            padding: 40px;
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

            .content-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .ticket-details,
            .chat-section {
                padding: 20px;
            }

            .ticket-meta {
                gap: 12px;
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

            .main header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .main header h1 {
                font-size: 20px;
            }

            .main header span {
                font-size: 13px;
            }

            .btn {
                padding: 8px 14px;
                font-size: 13px;
            }

            .content-grid {
                gap: 16px;
            }

            .ticket-details,
            .chat-section {
                padding: 16px;
            }

            .ticket-title {
                font-size: 18px;
            }

            .ticket-meta {
                flex-direction: column;
                gap: 6px;
                font-size: 13px;
            }

            .ticket-description {
                font-size: 14px;
                line-height: 1.5;
            }

            .status-section,
            .assignment-section {
                padding: 12px;
                margin-bottom: 20px;
            }

            .status-section h3,
            .assignment-section h3 {
                font-size: 15px;
            }

            .status-badge {
                padding: 4px 8px;
                font-size: 12px;
            }

            .priority-badge {
                padding: 3px 6px;
                font-size: 11px;
            }

            .form-group select {
                padding: 10px 12px;
                font-size: 16px; /* Previne zoom no iOS */
            }

            .chat-section h3 {
                font-size: 16px;
            }

            .chat-messages {
                max-height: 300px;
                margin-bottom: 12px;
            }

            .message {
                padding: 10px;
                margin-bottom: 12px;
            }

            .message-header {
                font-size: 11px;
            }

            .message-content {
                font-size: 14px;
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

            .main header h1 {
                font-size: 18px;
            }

            .btn {
                padding: 6px 12px;
                font-size: 12px;
            }

            .content-grid {
                gap: 12px;
            }

            .ticket-details,
            .chat-section {
                padding: 12px;
            }

            .ticket-title {
                font-size: 16px;
            }

            .ticket-meta {
                font-size: 12px;
            }

            .ticket-description {
                font-size: 13px;
            }

            .status-section,
            .assignment-section {
                padding: 10px;
                margin-bottom: 16px;
            }

            .status-section h3,
            .assignment-section h3 {
                font-size: 14px;
            }

            .status-badge {
                padding: 3px 6px;
                font-size: 11px;
            }

            .priority-badge {
                padding: 2px 5px;
                font-size: 10px;
            }

            .form-group select {
                padding: 8px 10px;
                font-size: 16px;
            }

            .chat-section h3 {
                font-size: 15px;
            }

            .chat-messages {
                max-height: 250px;
            }

            .message {
                padding: 8px;
                margin-bottom: 10px;
            }

            .message-header {
                font-size: 10px;
            }

            .message-content {
                font-size: 13px;
            }

            .no-messages {
                padding: 20px;
                font-size: 13px;
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
        <a href="{{ route('adm.users') }}">Usuários</a>
        <a href="{{ route('adm.tickets') }}" class="active">Chamados</a>
        <a href="#">Relatórios</a>
        <a href="#">Configurações</a>
        <a href="{{ route('logout') }}" class="logout">Sair</a>
    </aside>

    <!-- Conteúdo principal -->
    <main class="main">
        <header>
            <div>
                <h1>Chamado #{{ $ticket->id }}</h1>
                <span>Detalhes completos e gerenciamento</span>
            </div>
            <a href="{{ route('adm.tickets') }}" class="btn btn-secondary">← Voltar</a>
        </header>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
        @endif

        <div class="content-grid">
            <!-- Detalhes do chamado -->
            <div class="ticket-details">
                <div class="ticket-header">
                    <h2 class="ticket-title">{{ $ticket->title }}</h2>
                    <div class="ticket-meta">
                        <span>Cliente: {{ $ticket->user->name }}</span>
                        <span>Técnico: {{ $ticket->technician ? $ticket->technician->name : 'Não atribuído' }}</span>
                        <span>Criado em: {{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>

                <div class="ticket-description">
                    <strong>Descrição:</strong><br>
                    {{ $ticket->description }}
                </div>

                <div class="status-section">
                    <h3>Status e Prioridade</h3>
                    <div style="display: flex; gap: 16px; align-items: center; margin-bottom: 16px;">
                        <div>
                            <strong>Status:</strong>
                            <span class="status-badge status-{{ $ticket->status }}" style="margin-left: 8px;">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </div>
                        <div>
                            <strong>Prioridade:</strong>
                            <span class="priority-badge priority-{{ $ticket->priority }}" style="margin-left: 8px;">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('adm.ticket.status', $ticket->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="status">Alterar Status</label>
                            <select id="status" name="status" onchange="this.form.submit()">
                                <option value="">Selecione um status</option>
                                <option value="aberto" {{ $ticket->status == 'aberto' ? 'selected' : '' }}>Aberto</option>
                                <option value="em_atendimento" {{ $ticket->status == 'em_atendimento' ? 'selected' : '' }}>Em Atendimento</option>
                                <option value="finalizado" {{ $ticket->status == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                            </select>
                        </div>
                    </form>
                </div>

                <div class="assignment-section">
                    <h3>Atribuição de Técnico</h3>
                    @if($ticket->technician)
                    <p><strong>Técnico atual:</strong> {{ $ticket->technician->name }}</p>
                    @else
                    <p><em>Nenhum técnico atribuído</em></p>
                    @endif

                    <form method="POST" action="{{ route('adm.ticket.assign', $ticket->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="technician_id">Atribuir/Reatribuir Técnico</label>
                            <select id="technician_id" name="technician_id" onchange="this.form.submit()">
                                <option value="">Selecione um técnico</option>
                                @php
                                $technicians = \App\Models\User::role('tecnico')->get();
                                @endphp
                                @foreach($technicians as $technician)
                                <option value="{{ $technician->id }}" {{ ($ticket->technician && $ticket->technician->id == $technician->id) ? 'selected' : '' }}>
                                    {{ $technician->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Chat -->
            <div class="chat-section">
                <h3>Chat do Chamado</h3>

                <div class="chat-messages">
                    @forelse($messages as $message)
                    <div class="message">
                        <div class="message-header">
                            <strong>{{ $message->user->name }}</strong>
                            <span>{{ $message->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="message-content">
                            {{ $message->message }}
                            @if($message->attachment)
                            <div class="attachment" style="margin-top: 10px;">
                                <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank" style="color: var(--primary);">📎 Ver Anexo</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="no-messages">
                        Nenhuma mensagem ainda.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

</body>
</html>