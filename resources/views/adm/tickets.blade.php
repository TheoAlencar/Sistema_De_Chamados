<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--
        GERENCIAR CHAMADOS - tickets.blade.php
        Página administrativa para listagem e gerenciamento de chamados
        Permite visualizar, atribuir técnicos, alterar status e deletar chamados
        Filtros por status, prioridade e técnico responsável
    -->
    <title>Gerenciar Chamados | Sistema de Chamados</title>

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

        /* Filtros */
        .filters {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
        }

        .filters form {
            display: flex;
            gap: 16px;
            align-items: end;
            flex-wrap: wrap;
        }

        .filters .form-group {
            flex: 1;
            min-width: 200px;
        }

        .filters label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 6px;
            color: var(--text);
        }

        .filters input, .filters select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }

        .filters input:focus, .filters select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Tabela */
        .table-container {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background: #f9fafb;
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: var(--text);
            border-bottom: 1px solid #e5e7eb;
        }

        tbody td {
            padding: 16px;
            border-bottom: 1px solid #f3f4f6;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
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

        /* Estilo para o badge de status arquivado */
        /* Cor neutra (cinza) para indicar que é um status organizacional */
        .status-arquivado {
            background: #e5e7eb;
            color: #374151;
        }

        .priority-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 11px;
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

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .actions a, .actions button {
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        /* Paginação */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 24px;
            gap: 4px;
        }

        .pagination a, .pagination span {
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            border: 1px solid #d1d5db;
        }

        .pagination a:hover, .pagination .active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
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

            .filters form {
                gap: 12px;
            }

            .filters .form-group {
                min-width: 150px;
            }

            thead th,
            tbody td {
                padding: 12px;
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

            .filters {
                padding: 16px;
            }

            .filters form {
                flex-direction: column;
                align-items: stretch;
                gap: 16px;
            }

            .filters .form-group {
                width: 100%;
                min-width: auto;
            }

            .filters label {
                font-size: 13px;
            }

            .filters input,
            .filters select {
                padding: 10px 12px;
                font-size: 16px; /* Previne zoom no iOS */
            }

            .filters .btn {
                width: 100%;
                margin-top: 8px;
            }

            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            table {
                min-width: 800px;
                font-size: 14px;
            }

            thead th,
            tbody td {
                padding: 10px 8px;
            }

            .status-badge {
                font-size: 11px;
                padding: 3px 6px;
            }

            .priority-badge {
                font-size: 10px;
                padding: 2px 5px;
            }

            .actions {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
                min-width: 120px;
            }

            .actions a,
            .actions button {
                font-size: 11px;
                padding: 5px 8px;
            }

            .actions select {
                font-size: 12px;
                padding: 4px 6px;
                margin-top: 4px;
            }

            .pagination {
                padding: 16px;
                gap: 2px;
            }

            .pagination a,
            .pagination span {
                padding: 6px 10px;
                font-size: 13px;
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

            .filters {
                padding: 12px;
            }

            .filters form {
                gap: 12px;
            }

            .filters label {
                font-size: 12px;
            }

            .filters input,
            .filters select {
                padding: 8px 10px;
                font-size: 16px;
            }

            .table-container {
                margin: 0 -12px;
            }

            table {
                font-size: 12px;
            }

            thead th,
            tbody td {
                padding: 8px 6px;
            }

            .status-badge {
                font-size: 10px;
                padding: 2px 4px;
            }

            .priority-badge {
                font-size: 9px;
                padding: 1px 4px;
            }

            .actions {
                min-width: 100px;
            }

            .actions a,
            .actions button {
                font-size: 10px;
                padding: 4px 6px;
            }

            .actions select {
                font-size: 11px;
                padding: 3px 5px;
            }

            .pagination {
                padding: 12px;
            }

            .pagination a,
            .pagination span {
                padding: 5px 8px;
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
        <a href="{{ route('adm.tickets') }}" class="active">Chamados</a>
        <a href="{{ route('adm.tickets', ['include_archived' => 1, 'status' => 'arquivado']) }}">Chamados Arquivados</a>
        <a href="#">Relatórios</a>
        <a href="#">Configurações</a>
        <a href="{{ route('logout') }}" class="logout">Sair</a>
    </aside>

    <!-- Conteúdo principal -->
    <main class="main">
        <header>
            <div>
                <h1>Gerenciar Chamados</h1>
                <span>Controle total do fluxo de chamados</span>
            </div>
        </header>

        <!-- Filtros -->
        <div class="filters">
            <form method="GET" action="{{ route('adm.tickets') }}">
                <div class="form-group">
                    <label for="search">Buscar</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Título ou descrição...">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="">Todos os status</option>
                        <option value="aberto" {{ request('status') == 'aberto' ? 'selected' : '' }}>Aberto</option>
                        <option value="em_atendimento" {{ request('status') == 'em_atendimento' ? 'selected' : '' }}>Em Atendimento</option>
                        <option value="finalizado" {{ request('status') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                        <!-- Nova opção: permite filtrar chamados arquivados -->
                        <option value="arquivado" {{ request('status') == 'arquivado' ? 'selected' : '' }}>Arquivado</option>
                    </select>
                </div>
                <div class="form-group">
                    <!-- Checkbox para incluir chamados arquivados na listagem -->
                    <!-- Por padrão, arquivados ficam ocultos para manter foco nos ativos -->
                    <label for="include_archived">
                        <input type="checkbox" id="include_archived" name="include_archived" value="1" {{ request('include_archived') ? 'checked' : '' }}>
                        Incluir arquivados
                    </label>
                </div>
                <div class="form-group">
                    <label for="priority">Prioridade</label>
                    <select id="priority" name="priority">
                        <option value="">Todas as prioridades</option>
                        <option value="baixa" {{ request('priority') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                        <option value="media" {{ request('priority') == 'media' ? 'selected' : '' }}>Média</option>
                        <option value="alta" {{ request('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="technician_id">Técnico</label>
                    <select id="technician_id" name="technician_id">
                        <option value="">Todos os técnicos</option>
                        @foreach($technicians as $technician)
                        <option value="{{ $technician->id }}" {{ request('technician_id') == $technician->id ? 'selected' : '' }}>
                            {{ $technician->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('adm.tickets') }}" class="btn">Limpar</a>
            </form>
        </div>

        <!-- Tabela de chamados -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Cliente</th>
                        <th>Técnico</th>
                        <th>Status</th>
                        <th>Prioridade</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr>
                        <td>#{{ $ticket->id }}</td>
                        <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">{{ $ticket->title }}</td>
                        <td>{{ $ticket->user->name }}</td>
                        <td>{{ $ticket->technician ? $ticket->technician->name : 'Não atribuído' }}</td>
                        <td>
                            <span class="status-badge status-{{ $ticket->status }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </td>
                        <td>
                            <span class="priority-badge priority-{{ $ticket->priority }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </td>
                        <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                        <td class="actions">
                            <a href="{{ route('adm.ticket.show', $ticket->id) }}" style="background: var(--primary); color: #fff;">Ver</a>
                            @if(!$ticket->technician)
                            <form method="POST" action="{{ route('adm.ticket.assign', $ticket->id) }}" style="display: inline;">
                                @csrf
                                <select name="technician_id" onchange="this.form.submit()" style="font-size: 12px; padding: 4px; border-radius: 4px; border: 1px solid #d1d5db;">
                                    <option value="">Atribuir técnico</option>
                                    @foreach($technicians as $technician)
                                    <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                            @endif
                            <!-- Botão para arquivar chamado - apenas para finalizados -->
                            <!-- Confirmação necessária para evitar cliques acidentais -->
                            @if($ticket->status === 'finalizado')
                            <form method="POST" action="{{ route('adm.ticket.archive', $ticket->id) }}" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja arquivar este chamado?')">
                                @csrf
                                @method('POST')
                                <button type="submit" style="background: var(--warning); color: #fff; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px;">Arquivar</button>
                            </form>
                            @endif
                            <!-- Botão para deletar chamado -->
                            <form method="POST" action="{{ route('adm.ticket.delete', $ticket->id) }}" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja deletar este chamado? Esta ação não pode ser desfeita.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: var(--danger); color: #fff; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px;">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: var(--muted);">
                            Nenhum chamado encontrado.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        @if($tickets->hasPages())
        <div class="pagination">
            {{ $tickets->links() }}
        </div>
        @endif
    </main>

</body>
</html>