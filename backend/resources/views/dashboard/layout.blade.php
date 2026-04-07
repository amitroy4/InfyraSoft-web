<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        :root {
            --bg: #f3f6fb;
            --panel: #ffffff;
            --line: #e5e7eb;
            --text: #111827;
            --muted: #6b7280;
            --brand: #f7941d;
            --brand-dark: #c97312;
            --success-bg: #ecfdf3;
            --success-line: #bbf7d0;
            --success-text: #166534;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }
        .wrapper {
            display: grid;
            grid-template-columns: 260px 1fr;
            min-height: 100vh;
        }
        .sidebar {
            background: #0f172a;
            color: #e2e8f0;
            padding: 24px 18px;
            border-right: 1px solid #1f2937;
        }
        .brand {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 30px;
        }
        .brand span { color: var(--brand); }
        .menu {
            display: grid;
            gap: 10px;
        }
        .menu a {
            color: #cbd5e1;
            text-decoration: none;
            padding: 11px 13px;
            border-radius: 10px;
            font-weight: 600;
            border: 1px solid transparent;
        }
        .menu a.active,
        .menu a:hover {
            background: rgba(247, 148, 29, 0.15);
            border-color: rgba(247, 148, 29, 0.4);
            color: #fff;
        }
        .main {
            display: grid;
            grid-template-rows: auto 1fr;
        }
        .top {
            background: var(--panel);
            border-bottom: 1px solid var(--line);
            padding: 16px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
        }
        .top h1 {
            margin: 0;
            font-size: 21px;
        }
        .top p {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: 13px;
        }
        .logout {
            border: 1px solid #d1d5db;
            border-radius: 9px;
            background: #fff;
            padding: 10px 14px;
            font-weight: 700;
            cursor: pointer;
        }
        .content {
            padding: 28px;
        }
        .panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
        }
        .success {
            border: 1px solid var(--success-line);
            background: var(--success-bg);
            color: var(--success-text);
            border-radius: 10px;
            padding: 11px 14px;
            margin-bottom: 16px;
            font-weight: 600;
        }
        .field {
            margin-bottom: 16px;
        }
        .field label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            font-weight: 700;
            color: #374151;
        }
        .field input,
        .field textarea {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            padding: 11px 12px;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            background: #fff;
        }
        .field textarea {
            min-height: 88px;
            resize: vertical;
        }
        .field input:focus,
        .field textarea:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(247, 148, 29, 0.2);
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }
        .btn-primary {
            border: 0;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--brand), #ffc86f);
            color: #111827;
            font-weight: 800;
            padding: 12px 16px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border-bottom: 1px solid var(--line);
            text-align: left;
            padding: 11px 10px;
            vertical-align: top;
            font-size: 14px;
        }
        th {
            color: var(--muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }
        .muted {
            color: var(--muted);
            font-size: 13px;
        }
        @media (max-width: 980px) {
            .wrapper { grid-template-columns: 1fr; }
            .sidebar { display: none; }
            .content { padding: 14px; }
            .top { padding: 14px; }
            .grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <aside class="sidebar">
            <div class="brand">Infyra<span>Soft</span> Admin</div>
            <nav class="menu">
                <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">Website Content</a>
                <a href="/dashboard/leads" class="{{ request()->is('dashboard/leads') ? 'active' : '' }}">Lead Inbox</a>
            </nav>
        </aside>

        <div class="main">
            <header class="top">
                <div>
                    <h1>@yield('title')</h1>
                    <p>Manage dynamic content for the landing page.</p>
                </div>
                <form method="POST" action="/logout">
                    @csrf
                    <button class="logout" type="submit">Logout</button>
                </form>
            </header>

            <main class="content">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
