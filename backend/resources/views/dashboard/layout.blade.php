<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Admin</title>
    <style>
        :root {
            --bg: #eef2f7;
            --panel: #ffffff;
            --line: #d9e1ec;
            --text: #0f172a;
            --muted: #64748b;
            --brand: #f7941d;
            --brand-soft: #fff2df;
            --sidebar-1: #0b1220;
            --sidebar-2: #121b2e;
            --sidebar-line: #243146;
            --focus: rgba(247, 148, 29, 0.22);
            --shadow-1: 0 10px 26px rgba(15, 23, 42, 0.06);
            --shadow-2: 0 16px 44px rgba(15, 23, 42, 0.12);
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
            grid-template-columns: 290px 1fr;
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(180deg, var(--sidebar-1), var(--sidebar-2));
            color: #e2e8f0;
            border-right: 1px solid var(--sidebar-line);
            padding: 22px 16px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .brand {
            display: flex;
            align-items: baseline;
            gap: 2px;
            font-size: 24px;
            font-weight: 900;
            padding: 6px 8px 14px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
            margin-bottom: 16px;
            letter-spacing: -0.2px;
        }

        .brand .soft,
        .brand .tag {
            color: var(--brand);
        }

        .brand .tag {
            font-size: 10px;
            margin-left: 5px;
            letter-spacing: 1.2px;
            font-weight: 800;
        }

        .menu-group {
            margin-bottom: 18px;
        }

        .menu-title {
            font-size: 11px;
            letter-spacing: 0.7px;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 700;
            margin: 0 10px 8px;
        }

        .menu {
            display: grid;
            gap: 6px;
        }

        .menu a {
            color: #cbd5e1;
            text-decoration: none;
            padding: 11px 12px;
            border-radius: 10px;
            border: 1px solid transparent;
            font-size: 14px;
            font-weight: 650;
            transition: all 0.2s ease;
            position: relative;
        }

        .menu a:hover {
            background: rgba(247, 148, 29, 0.12);
            border-color: rgba(247, 148, 29, 0.4);
            color: #fff;
            transform: translateX(2px);
        }

        .menu a.active {
            background: linear-gradient(135deg, rgba(247, 148, 29, 0.24), rgba(247, 148, 29, 0.1));
            border-color: rgba(247, 148, 29, 0.45);
            color: #fff;
            box-shadow: inset 0 0 0 1px rgba(247, 148, 29, 0.1);
        }

        .menu a.active::before {
            content: "";
            position: absolute;
            left: -8px;
            top: 7px;
            bottom: 7px;
            width: 3px;
            border-radius: 4px;
            background: var(--brand);
        }

        .main {
            display: grid;
            grid-template-rows: auto 1fr;
        }

        .top {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--line);
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .top h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.2px;
        }

        .top p {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .logout {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            background: #fff;
            padding: 10px 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .logout:hover {
            border-color: #94a3b8;
            transform: translateY(-1px);
        }

        .content {
            padding: 22px;
        }

        .panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 22px;
            box-shadow: var(--shadow-1);
        }

        .panel-head {
            margin-bottom: 14px;
        }

        .panel-head h2 {
            margin: 0;
            font-size: 17px;
            font-weight: 800;
        }

        .panel-head p {
            margin: 5px 0 0;
            font-size: 13px;
            color: var(--muted);
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
            color: #334155;
        }

        .toggle-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 4px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 52px;
            height: 30px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }

        .switch-slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background: #cbd5e1;
            border-radius: 999px;
            transition: all 0.22s ease;
            border: 1px solid #b6c3d4;
        }

        .switch-slider::before {
            content: "";
            position: absolute;
            width: 22px;
            height: 22px;
            left: 3px;
            top: 3px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 1px 6px rgba(15, 23, 42, 0.2);
            transition: transform 0.22s ease;
        }

        .switch input:checked + .switch-slider {
            background: linear-gradient(135deg, var(--brand), #ffbf60);
            border-color: rgba(247, 148, 29, 0.65);
        }

        .switch input:checked + .switch-slider::before {
            transform: translateX(22px);
        }

        .switch input:focus + .switch-slider {
            box-shadow: 0 0 0 3px var(--focus);
        }

        .toggle-state {
            font-size: 13px;
            font-weight: 700;
            color: #334155;
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
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .field textarea {
            min-height: 100px;
            resize: vertical;
        }

        .field input:focus,
        .field textarea:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px var(--focus);
        }

        .hint {
            margin: 6px 0 0;
            font-size: 12px;
            color: var(--muted);
        }

        .preview-img {
            max-height: 64px;
            width: auto;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 6px;
            background: #fff;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .actions-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .btn-primary {
            border: 0;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--brand), #ffc86f);
            color: #111827;
            font-weight: 800;
            padding: 12px 16px;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 8px 18px rgba(247, 148, 29, 0.26);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(247, 148, 29, 0.34);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 12px;
            border: 1px solid var(--line);
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
            letter-spacing: 0.4px;
            background: #f8fafc;
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
            .panel { padding: 16px; border-radius: 14px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <aside class="sidebar">
            <div class="brand">
                <span>Infyra</span><span class="soft">Soft</span><span class="tag">ADMIN</span>
            </div>

            <div class="menu-group">
                <p class="menu-title">Content Editor</p>
                <nav class="menu">
                    <a href="{{ route('dashboard.branding') }}" class="{{ request()->routeIs('dashboard.branding*') ? 'active' : '' }}">Branding</a>
                    <a href="{{ route('dashboard.home') }}" class="{{ request()->routeIs('dashboard.home*') ? 'active' : '' }}">Home Section</a>
                    <a href="{{ route('dashboard.about') }}" class="{{ request()->routeIs('dashboard.about*') ? 'active' : '' }}">About Section</a>
                    <a href="{{ route('dashboard.core-services') }}" class="{{ request()->routeIs('dashboard.core-services*') ? 'active' : '' }}">Our Core Services</a>
                    <a href="{{ route('dashboard.products') }}" class="{{ request()->routeIs('dashboard.products*') ? 'active' : '' }}">Ready-Made Software Products</a>
                    <a href="{{ route('dashboard.clients') }}" class="{{ request()->routeIs('dashboard.clients*') ? 'active' : '' }}">Our Clients</a>
                    <a href="{{ route('dashboard.blog') }}" class="{{ request()->routeIs('dashboard.blog*') ? 'active' : '' }}">Case Studies & Blog</a>
                    <a href="{{ route('dashboard.contact') }}" class="{{ request()->routeIs('dashboard.contact*') ? 'active' : '' }}">Contact Section</a>
                    <a href="{{ route('dashboard.stats') }}" class="{{ request()->routeIs('dashboard.stats*') ? 'active' : '' }}">Stats Section</a>
                    <a href="{{ route('dashboard.footer') }}" class="{{ request()->routeIs('dashboard.footer*') ? 'active' : '' }}">Footer Section</a>
                </nav>
            </div>

            <div class="menu-group">
                <p class="menu-title">Management</p>
                <nav class="menu">
                    <a href="{{ route('dashboard.leads') }}" class="{{ request()->routeIs('dashboard.leads') ? 'active' : '' }}">Lead Inbox</a>
                </nav>
            </div>
        </aside>

        <div class="main">
            <header class="top">
                <div>
                    <h1>@yield('title')</h1>
                    <p>@yield('subtitle', 'Manage your landing page content section by section.')</p>
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
