<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AutoAdmin') – Administration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --blue: #2563EB; --blue-dark: #1D4ED8; --blue-light: #EFF6FF;
            --orange: #F59E0B; --orange-dark: #D97706;
            --sidebar-bg: #0F172A; --sidebar-hover: #1E293B; --sidebar-active: #2563EB;
            --gray-50: #F9FAFB; --gray-100: #F3F4F6; --gray-200: #E5E7EB;
            --gray-400: #9CA3AF; --gray-500: #6B7280; --gray-700: #374151;
            --gray-900: #111827; --red: #EF4444;
            --radius: 12px; --radius-sm: 8px;
        }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
            display: flex; min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 240px; background: var(--sidebar-bg);
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; bottom: 0;
            z-index: 50;
        }
        .sidebar-brand {
            display: flex; align-items: center; gap: 10px;
            padding: 20px 20px 24px;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .sidebar-logo {
            width: 36px; height: 36px;
            background: var(--blue); border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 16px;
        }
        .sidebar-brand-name { font-size: 17px; font-weight: 700; color: #fff; }
        .sidebar-nav {
            flex: 1; padding: 16px 12px;
            display: flex; flex-direction: column; gap: 2px;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 9px;
            text-decoration: none;
            font-size: 14px; font-weight: 500;
            color: rgba(255,255,255,.55);
            transition: all .15s;
        }
        .sidebar-link i { width: 18px; text-align: center; font-size: 15px; }
        .sidebar-link:hover { background: var(--sidebar-hover); color: rgba(255,255,255,.85); }
        .sidebar-link.active { background: var(--sidebar-active); color: #fff; }
        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid rgba(255,255,255,.06);
        }
        .sidebar-link.logout { color: rgba(239,68,68,.7); }
        .sidebar-link.logout:hover { background: rgba(239,68,68,.1); color: var(--red); }

        /* ── MAIN ── */
        .main-content {
            margin-left: 240px;
            flex: 1; padding: 36px;
            min-height: 100vh;
        }
        .page-header {
            display: flex; justify-content: space-between; align-items: flex-start;
            margin-bottom: 32px;
        }
        .page-header h1 { font-size: 26px; font-weight: 700; }
        .page-header p { font-size: 14px; color: var(--gray-500); margin-top: 4px; }

        /* ── STAT CARDS ── */
        .stats-grid {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 16px; margin-bottom: 28px;
        }
        .stat-card {
            background: #fff; border-radius: var(--radius);
            border: 1px solid var(--gray-200);
            padding: 20px;
            display: flex; flex-direction: column; gap: 12px;
        }
        .stat-top {
            display: flex; justify-content: space-between; align-items: center;
        }
        .stat-label { font-size: 13px; color: var(--gray-500); font-weight: 500; }
        .stat-icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }
        .stat-value { font-size: 30px; font-weight: 700; }

        /* ── TABLE ── */
        .table-card {
            background: #fff; border-radius: var(--radius);
            border: 1px solid var(--gray-200); overflow: hidden;
        }
        .table-card table { width: 100%; border-collapse: collapse; }
        .table-card th {
            padding: 14px 20px; text-align: left;
            font-size: 13px; font-weight: 600; color: var(--gray-500);
            border-bottom: 1px solid var(--gray-200);
        }
        .table-card td {
            padding: 16px 20px;
            font-size: 14px; color: var(--gray-700);
            border-bottom: 1px solid var(--gray-100);
        }
        .table-card tr:last-child td { border-bottom: none; }
        .table-card tr:hover td { background: var(--gray-50); }

        /* ── FORMS & CARDS ── */
        .form-card {
            background: #fff; border-radius: var(--radius);
            border: 1px solid var(--gray-200); padding: 28px;
        }
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block; font-size: 14px; font-weight: 500;
            color: var(--gray-700); margin-bottom: 7px;
        }
        .form-input {
            width: 100%; padding: 12px 14px;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-sm);
            font-size: 15px; font-family: inherit;
            color: var(--gray-900);
            outline: none; transition: border-color .15s;
        }
        .form-input:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(37,99,235,.1); }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 10px 18px; border-radius: var(--radius-sm);
            font-size: 14px; font-weight: 600;
            cursor: pointer; border: none; text-decoration: none;
            transition: all .15s;
        }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-primary:hover { background: var(--blue-dark); }
        .btn-orange { background: var(--orange); color: #fff; }
        .btn-outline {
            background: #fff; color: var(--gray-700);
            border: 1px solid var(--gray-200);
        }
        .btn-outline:hover { border-color: var(--blue); color: var(--blue); }
        .btn-icon {
            width: 32px; height: 32px; padding: 0;
            display: flex; align-items: center; justify-content: center;
            border-radius: 8px; border: 1px solid var(--gray-200);
            background: #fff; cursor: pointer;
            color: var(--gray-500); font-size: 13px;
            transition: all .15s;
        }
        .btn-icon:hover { border-color: var(--blue); color: var(--blue); }
        .btn-icon.danger:hover { border-color: var(--red); color: var(--red); }

        /* ── BADGE STATUS ── */
        .status-active  { background: #D1FAE5; color: #065F46; }
        .status-inactive { background: #FEE2E2; color: #991B1B; }

        @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2,1fr); } }
    </style>
    @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-logo"><i class="fa-solid fa-car"></i></div>
        <span class="sidebar-brand-name">AutoAdmin</span>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-grid-2"></i>
            Tableau de bord
        </a>
        <a href="{{ route('admin.marques.index') }}" class="sidebar-link {{ request()->routeIs('admin.marques.*') ? 'active' : '' }}">
            <i class="fa-solid fa-tag"></i>
            Marques
        </a>
        <a href="{{ route('admin.vehicules.index') }}" class="sidebar-link {{ request()->routeIs('admin.vehicules.*') ? 'active' : '' }}">
            <i class="fa-solid fa-car"></i>
            Véhicules
        </a>
        <a href="{{ route('admin.clients.index') }}" class="sidebar-link {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i>
            Clients
        </a>
        <a href="{{ route('admin.forum.index') }}" class="sidebar-link {{ request()->routeIs('admin.forum.*') ? 'active' : '' }}">
            <i class="fa-solid fa-comments"></i>
            Forum
        </a>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="sidebar-link logout" style="width:100%;background:none;border:none;cursor:pointer;text-align:left">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                Déconnexion
            </button>
        </form>
    </div>
</aside>

{{-- CONTENT --}}
<main class="main-content">
    @yield('content')
</main>

@stack('scripts')
</body>
</html>
