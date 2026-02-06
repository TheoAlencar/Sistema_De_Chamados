<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--
        GERENCIAR USUÁRIOS - users.blade.php
        Página administrativa para listagem e gerenciamento de usuários
        Permite visualizar, criar, editar e deletar usuários
        Filtros por papel e busca por nome/email
    -->
    <title>Gerenciar Usuários | Sistema de Chamados</title>

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

        .btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-success {
            background: var(--success);
            color: #fff;
        }

        .btn-success:hover {
            background: #059669;
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

        .role-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .role-adm {
            background: #fef3c7;
            color: #92400e;
        }

        .role-tecnico {
            background: #dbeafe;
            color: #1e40af;
        }

        .role-cliente {
            background: #d1fae5;
            color: #065f46;
        }

        .actions {
            display: flex;
            gap: 8px;
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

        /* Modal de confirmação */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: var(--card-bg);
            padding: 24px;
            border-radius: 12px;
            max-width: 400px;
            width: 90%;
        }

        .modal-content h3 {
            margin: 0 0 16px;
            font-size: 18px;
        }

        .modal-content p {
            margin: 0 0 20px;
            color: var(--muted);
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
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
                margin-left: 200px;
            }

            .filters form {
                gap: 12px;
            }

            .form-group {
                flex: 1;
                min-width: 150px;
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
            }

            header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            header h1 {
                font-size: 24px;
            }

            header span {
                font-size: 14px;
            }

            .filters form {
                flex-direction: column;
                align-items: stretch;
                gap: 16px;
            }

            .form-group {
                width: 100%;
            }

            .form-group label {
                display: block;
                margin-bottom: 4px;
                font-weight: 500;
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
                min-width: 600px;
                font-size: 14px;
            }

            th, td {
                padding: 8px 6px;
            }

            .actions {
                min-width: 120px;
            }

            .actions .btn-success,
            .actions .btn-danger {
                padding: 6px 8px;
                font-size: 12px;
                margin: 2px;
            }

            .pagination {
                padding: 16px;
            }

            .pagination .page-link {
                padding: 8px 12px;
                font-size: 14px;
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
            }

            header {
                padding: 16px;
            }

            header h1 {
                font-size: 20px;
            }

            .filters {
                padding: 16px;
            }

            .table-container {
                margin: 0 16px;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 6px 4px;
            }

            .role-badge {
                font-size: 10px;
                padding: 2px 6px;
            }

            .actions {
                min-width: 100px;
            }

            .actions .btn-success,
            .actions .btn-danger {
                padding: 4px 6px;
                font-size: 11px;
            }

            .modal-content {
                margin: 20px;
                padding: 20px;
                width: calc(100% - 40px);
            }

            .modal h3 {
                font-size: 18px;
            }

            .modal p {
                font-size: 14px;
            }

            .modal-actions {
                flex-direction: column;
                gap: 12px;
            }

            .modal-actions .btn {
                width: 100%;
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
        <header>
            <div>
                <h1>Gerenciar Usuários</h1>
                <span>Controle de usuários do sistema</span>
            </div>
            <a href="{{ route('adm.users.create') }}" class="btn btn-primary">Novo Usuário</a>
        </header>

        <!-- Filtros -->
        <div class="filters">
            <form method="GET" action="{{ route('adm.users') }}">
                <div class="form-group">
                    <label for="search">Buscar</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Nome, email ou CPF...">
                </div>
                <div class="form-group">
                    <label for="role">Papel</label>
                    <select id="role" name="role">
                        <option value="">Todos os papéis</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('adm.users') }}" class="btn">Limpar</a>
            </form>
        </div>

        <!-- Tabela de usuários -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Email</th>
                        <th>Papel</th>
                        <th>Data Cadastro</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->cpf }}</td>
                        <td>{{ $user->email ?: 'Não informado' }}</td>
                        <td>
                            @if($user->roles->count() > 0)
                                <span class="role-badge role-{{ $user->roles->first()->name }}">
                                    {{ ucfirst($user->roles->first()->name) }}
                                </span>
                            @else
                                <span class="role-badge" style="background: #fee2e2; color: #991b1b;">Sem papel</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="actions">
                            <a href="{{ route('adm.users.edit', $user->id) }}" class="btn-success">Editar</a>
                            @if($user->id !== auth()->id())
                            <button onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" class="btn-danger">Excluir</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--muted);">
                            Nenhum usuário encontrado.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        @if($users->hasPages())
        <div class="pagination">
            {{ $users->links() }}
        </div>
        @endif
    </main>

    <!-- Modal de confirmação de exclusão -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3>Confirmar Exclusão</h3>
            <p>Tem certeza que deseja excluir o usuário <strong id="userName"></strong>? Esta ação não pode ser desfeita.</p>
            <div class="modal-actions">
                <button onclick="closeModal()" class="btn">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(userId, userName) {
            document.getElementById('userName').textContent = userName;
            document.getElementById('deleteForm').action = '{{ route("adm.users.delete", ":id") }}'.replace(':id', userId);
            document.getElementById('deleteModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.remove('show');
        }

        // Fechar modal ao clicar fora
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>

</body>
</html>