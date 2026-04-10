<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AutoMoto') – La plateforme automobile N°1</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue:        #2563EB;
            --blue-dark:   #1D4ED8;
            --blue-light:  #EFF6FF;
            --orange:      #F59E0B;
            --orange-dark: #D97706;
            --gray-50:     #F9FAFB;
            --gray-100:    #F3F4F6;
            --gray-200:    #E5E7EB;
            --gray-400:    #9CA3AF;
            --gray-500:    #6B7280;
            --gray-700:    #374151;
            --gray-900:    #111827;
            --red:         #EF4444;
            --radius:      12px;
            --radius-sm:   8px;
            --shadow:      0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.06);
            --shadow-md:   0 4px 12px rgba(0,0,0,.08);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--gray-900);
            background: var(--gray-50);
            min-height: 100vh;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            height: 64px;
            display: flex;
            align-items: center;
            gap: 32px;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            flex-shrink: 0;
        }
        .navbar-logo {
            width: 38px; height: 38px;
            background: var(--blue);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 18px;
        }
        .navbar-brand-name {
            font-weight: 700;
            font-size: 18px;
            color: var(--gray-900);
        }
        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 4px;
            flex: 1;
        }
        .navbar-nav a {
            padding: 6px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            color: var(--gray-500);
            transition: all .15s;
        }
        .navbar-nav a:hover,
        .navbar-nav a.active {
            color: var(--blue);
            background: var(--blue-light);
        }
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }
        .btn-account {
            display: flex; align-items: center; gap: 8px;
            padding: 7px 16px;
            border-radius: 8px;
            border: 1px solid var(--gray-200);
            background: var(--gray-50);
            font-size: 14px; font-weight: 500;
            color: var(--gray-700);
            text-decoration: none;
            transition: all .15s;
        }
        .btn-account:hover { border-color: var(--blue); color: var(--blue); }
        .btn-logout {
            display: flex; align-items: center; gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            border: none; background: none;
            font-size: 14px; font-weight: 500;
            color: var(--red);
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
        }
        .btn-logout:hover { background: #FEF2F2; }

        /* ── BREADCRUMB ── */
        .breadcrumb {
            max-width: 1200px;
            margin: 0 auto;
            padding: 16px 24px 0;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: var(--gray-400);
        }
        .breadcrumb a { color: var(--gray-500); text-decoration: none; }
        .breadcrumb a:hover { color: var(--blue); }
        .breadcrumb .sep { color: var(--gray-300); }
        .breadcrumb .current { color: var(--gray-900); font-weight: 500; }

        /* ── CONTAINER ── */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 12px 24px;
            border-radius: var(--radius);
            font-size: 15px; font-weight: 600;
            cursor: pointer; border: none;
            text-decoration: none;
            transition: all .15s;
        }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-primary:hover { background: var(--blue-dark); }
        .btn-orange { background: var(--orange); color: #fff; }
        .btn-orange:hover { background: var(--orange-dark); }
        .btn-outline {
            background: #fff; color: var(--gray-700);
            border: 1px solid var(--gray-200);
        }
        .btn-outline:hover { border-color: var(--blue); color: var(--blue); }

        /* ── BADGES ── */
        .badge {
            display: inline-flex; align-items: center;
            padding: 3px 10px; border-radius: 20px;
            font-size: 12px; font-weight: 600;
        }
        .badge-blue { background: var(--blue-light); color: var(--blue); }
        .badge-green { background: #D1FAE5; color: #065F46; }
        .badge-orange { background: #FEF3C7; color: #92400E; }
        .badge-red { background: #FEE2E2; color: #991B1B; }
        .badge-gray { background: var(--gray-100); color: var(--gray-500); }
        .badge-purple { background: #EDE9FE; color: #5B21B6; }

        /* ── AVATAR ICON ── */
        .avatar {
            width: 42px; height: 42px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 16px;
            flex-shrink: 0;
        }

        /* ── CARDS ── */
        .card {
            background: #fff;
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow);
        }

        /* ── FORM ELEMENTS ── */
        .form-label {
            display: block;
            font-size: 14px; font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 6px;
        }
        .form-input {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-sm);
            font-size: 15px;
            font-family: inherit;
            color: var(--gray-900);
            background: #fff;
            transition: border-color .15s;
            outline: none;
        }
        .form-input::placeholder { color: var(--gray-400); }
        .form-input:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        @media (max-width: 768px) {
            .navbar-nav { display: none; }
            .navbar-inner { gap: 16px; }
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-brand">
            <div class="navbar-logo"><i class="fa-solid fa-car"></i></div>
            <span class="navbar-brand-name">AutoMoto</span>
        </a>
        <nav class="navbar-nav">
            <a href="{{ route('voitures.index') }}" class="{{ request()->routeIs('voitures.*') ? 'active' : '' }}">Voitures Neuves</a>
            <a href="{{ route('comparer') }}" class="{{ request()->routeIs('comparer') ? 'active' : '' }}">Comparer</a>
            <a href="{{ route('occasions.index') }}" class="{{ request()->routeIs('occasions.*') ? 'active' : '' }}">Occasions</a>
            <a href="{{ route('forum.index') }}" class="{{ request()->routeIs('forum.*') ? 'active' : '' }}">Forum</a>
        </nav>
        <div class="navbar-actions">
            @auth
                <a href="{{ route('profile.edit') }}" class="btn-account">
                    <i class="fa-regular fa-user" style="font-size:14px"></i>
                    {{ explode(' ', Auth::user()->name)[0] }}
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fa-solid fa-arrow-right-from-bracket" style="font-size:13px"></i>
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-account">Se connecter</a>
                <a href="{{ route('register') }}" class="btn btn-primary" style="padding:8px 18px;font-size:14px">S'inscrire</a>
            @endauth
        </div>
    </div>
</nav>

@yield('content')

@stack('scripts')
</body>
</html>
