<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Abrir Novo Chamado | Sistema de Chamados</title>

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

        /* Formulário */
        .form-container {
            background: var(--card-bg);
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
            max-width: 600px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: var(--text);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
        }

        .error {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
        }

        .buttons {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: var(--muted);
            color: #fff;
        }

        .btn-secondary:hover {
            background: #4b5563;
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
        <a href="{{ route('cliente.homepage') }}">Dashboard</a>
        <a href="#">Meus Chamados</a>
        <a href="#">Abrir Chamado</a>
        <a href="#">Chat com Técnico</a>
        <a href="{{ route('logout') }}" class="logout">Sair</a>
    </aside>

    <!-- Conteúdo principal -->
    <main class="main">
        <header>
            <div>
                <h1>Abrir Novo Chamado</h1>
                <span>Descreva seu problema para que possamos ajudá-lo</span>
            </div>
        </header>

        <!-- Formulário -->
        <div class="form-container">
            <form action="{{ route('cliente.ticket.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="title">Título do Chamado</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="priority">Prioridade</label>
                    <select id="priority" name="priority" required>
                        <option value="">Selecione a prioridade</option>
                        <option value="baixa" {{ old('priority') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                        <option value="media" {{ old('priority') == 'media' ? 'selected' : '' }}>Média</option>
                        <option value="alta" {{ old('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                    </select>
                    @error('priority')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Descrição do Problema</label>
                    <textarea id="description" name="description" placeholder="Descreva detalhadamente o problema que você está enfrentando..." required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="buttons">
                    <a href="{{ route('cliente.homepage') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Abrir Chamado</button>
                </div>
            </form>
        </div>

        <footer>
            © 2025 Sistema de Chamados — Abrir Novo Chamado
        </footer>
    </main>

</body>
</html>