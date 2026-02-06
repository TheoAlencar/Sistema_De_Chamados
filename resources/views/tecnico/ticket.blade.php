<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detalhes do Chamado | Sistema de Chamados</title>

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
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
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
            color: #cbd5e1;
            text-decoration: none;
            font-size: 14px;
            display: block;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .sidebar a:hover {
            background: #1e293b;
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

        /* Detalhes do chamado */
        .ticket-details {
            background: var(--card-bg);
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
        }

        .ticket-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .ticket-id {
            font-size: 18px;
            font-weight: 600;
        }

        .ticket-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-aberto { background: var(--warning); color: #fff; }
        .status-em_atendimento { background: var(--primary); color: #fff; }
        .status-finalizado { background: var(--success); color: #fff; }

        .ticket-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 12px;
            color: var(--muted);
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 500;
        }

        .ticket-description {
            margin-bottom: 20px;
        }

        .ticket-description h3 {
            margin: 0 0 8px;
            font-size: 16px;
            font-weight: 600;
        }

        .ticket-description p {
            margin: 0;
            line-height: 1.6;
        }

        /* Status update */
        .status-update {
            background: var(--bg);
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .status-update h4 {
            margin: 0 0 12px;
            font-size: 14px;
        }

        .status-form {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .status-form select {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }

        .status-form button {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }

        .status-form button:hover {
            background: var(--primary-dark);
        }

        /* Chat */
        .chat-section {
            background: var(--card-bg);
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
        }

        .chat-section h3 {
            margin: 0 0 16px;
            font-size: 18px;
        }

        .chat-messages {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 16px;
            padding: 12px;
            background: var(--bg);
            border-radius: 8px;
        }

        .message {
            margin-bottom: 12px;
            padding: 8px 12px;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .message .sender {
            font-weight: 600;
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 4px;
        }

        .message .text {
            font-size: 14px;
            line-height: 1.4;
        }

        .chat-input {
            display: flex;
            gap: 12px;
        }

        .chat-input textarea {
            flex: 1;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            resize: vertical;
            font-family: inherit;
        }

        .chat-input button {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 12px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .chat-input button:hover {
            background: var(--primary-dark);
        }

        /* Botões de ação */
        .actions {
            margin-top: 24px;
            text-align: right;
        }

        .actions a {
            background: var(--muted);
            color: #fff;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            margin-left: 12px;
        }

        .actions a:hover {
            background: #4b5563;
        }

        /* Alertas */
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
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
        <a href="{{ route('tecnico.homepage') }}">Dashboard</a>
        <a href="#">Meus Chamados</a>
        <a href="#">Em Atendimento</a>
        <a href="#">Finalizados</a>
        <a href="{{ route('logout') }}" class="logout">Sair</a>
    </aside>

    <!-- Conteúdo principal -->
    <main class="main">
        <header>
            <div>
                <h1>Detalhes do Chamado</h1>
                <span>Gerencie o atendimento e converse com o cliente</span>
            </div>
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

        <!-- Detalhes do chamado -->
        <section class="ticket-details">
            <div class="ticket-header">
                <span class="ticket-id">#{{ $ticket->id }} - {{ $ticket->title }}</span>
                <span class="ticket-status status-{{ $ticket->status }}">{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</span>
            </div>

            <div class="ticket-info">
                <div class="info-item">
                    <span class="info-label">Data de abertura</span>
                    <span class="info-value">{{ $ticket->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Cliente</span>
                    <span class="info-value">{{ $ticket->user->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Última atualização</span>
                    <span class="info-value">{{ $ticket->updated_at->format('d/m/Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Prioridade</span>
                    <span class="info-value">{{ ucfirst($ticket->priority) }}</span>
                </div>
            </div>

            <div class="ticket-description">
                <h3>Descrição do problema</h3>
                <p>{{ $ticket->description }}</p>
            </div>

            <!-- Atualizar status -->
            <div class="status-update">
                <h4>Atualizar Status</h4>
                <form class="status-form" action="{{ route('tecnico.ticket.status', $ticket->id) }}" method="POST">
                    @csrf
                    <select name="status" required>
                        <option value="aberto" {{ $ticket->status == 'aberto' ? 'selected' : '' }}>Aberto</option>
                        <option value="em_atendimento" {{ $ticket->status == 'em_atendimento' ? 'selected' : '' }}>Em Atendimento</option>
                        <option value="finalizado" {{ $ticket->status == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                    </select>
                    <button type="submit">Atualizar</button>
                </form>
            </div>
        </section>

        <!-- Chat com cliente -->
        <section class="chat-section">
            <h3>Chat com o Cliente</h3>
            <div class="chat-messages">
                @forelse($messages as $message)
                <div class="message">
                    <div class="sender">{{ $message->user->name }} - {{ $message->created_at->format('d/m/Y H:i') }}</div>
                    <div class="text">{{ $message->message }}</div>
                    @if($message->attachment)
                    <div class="attachment">
                        <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank">📎 Ver Anexo</a>
                    </div>
                    @endif
                </div>
                @empty
                <div class="message">
                    <div class="text">Nenhuma mensagem ainda.</div>
                </div>
                @endforelse
            </div>

            <form class="chat-input" action="{{ route('tecnico.message.store', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <textarea name="message" placeholder="Digite sua mensagem para o cliente..." rows="3" required></textarea>
                <input type="file" name="attachment" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" style="margin-bottom: 10px;">
                <button type="submit">Enviar</button>
            </form>
        </section>

        <!-- Ações -->
        <div class="actions">
            <a href="{{ route('tecnico.homepage') }}">Voltar ao Dashboard</a>
        </div>

        <footer>
            © 2025 Sistema de Chamados — Detalhes do Chamado
        </footer>
    </main>

</body>
</html>