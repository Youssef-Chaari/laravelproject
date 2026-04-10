<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Connexion') – AutoMoto</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --blue: #2563EB; --blue-dark: #1D4ED8;
            --orange: #F59E0B;
            --gray-200: #E5E7EB; --gray-400: #9CA3AF;
            --gray-500: #6B7280; --gray-700: #374151; --gray-900: #111827;
            --radius: 12px; --radius-sm: 8px;
        }
        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh; display: flex;
        }

        /* ── LEFT PANEL ── */
        .auth-left {
            width: 47%;
            background: linear-gradient(145deg, #1E3A8A 0%, #1D4ED8 40%, #312E81 100%);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }
        .auth-left::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse at 30% 70%, rgba(99,102,241,.35) 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 20%, rgba(37,99,235,.25) 0%, transparent 50%);
        }
        .auth-left-content { position: relative; text-align: center; color: #fff; }
        .auth-car-icon {
            width: 100px; height: 100px;
            margin: 0 auto 32px;
            display: flex; align-items: center; justify-content: center;
        }
        .auth-car-icon svg { width: 100%; height: 100%; }
        .auth-left h1 {
            font-size: 30px; font-weight: 700;
            line-height: 1.2; margin-bottom: 16px;
        }
        .auth-left p {
            font-size: 16px; color: rgba(255,255,255,.75);
            line-height: 1.6; max-width: 320px;
        }

        /* ── RIGHT PANEL ── */
        .auth-right {
            flex: 1;
            background: #fff;
            display: flex; flex-direction: column;
            padding: 48px;
            overflow-y: auto;
        }
        .auth-back {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 14px; font-weight: 500;
            color: var(--gray-500); text-decoration: none;
            margin-bottom: 40px;
            transition: color .15s;
        }
        .auth-back:hover { color: var(--blue); }
        .auth-right h2 {
            font-size: 28px; font-weight: 700;
            color: var(--gray-900); margin-bottom: 6px;
        }
        .auth-right .subtitle {
            font-size: 15px; color: var(--gray-500); margin-bottom: 32px;
        }

        /* ── TAB TOGGLE ── */
        .auth-tabs {
            display: flex;
            background: var(--gray-100);
            border-radius: var(--radius);
            padding: 4px;
            margin-bottom: 32px;
        }
        .auth-tab {
            flex: 1; padding: 10px;
            border: none; background: none;
            border-radius: 9px;
            font-size: 15px; font-weight: 500;
            color: var(--gray-500);
            cursor: pointer; transition: all .2s;
            text-align: center; text-decoration: none;
            display: block;
        }
        .auth-tab.active {
            background: #fff;
            color: var(--gray-900);
            box-shadow: 0 1px 4px rgba(0,0,0,.12);
        }

        /* ── FORM ── */
        .form-group { margin-bottom: 20px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-label {
            display: flex; justify-content: space-between;
            font-size: 14px; font-weight: 500;
            color: var(--gray-700); margin-bottom: 7px;
        }
        .form-label a {
            color: var(--blue); font-weight: 500; text-decoration: none;
            font-size: 13px;
        }
        .form-input {
            width: 100%; padding: 12px 14px;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-sm);
            font-size: 15px; font-family: inherit;
            color: var(--gray-900);
            outline: none; transition: border-color .15s;
        }
        .form-input::placeholder { color: var(--gray-400); }
        .form-input:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(37,99,235,.1); }

        .btn-submit {
            width: 100%; padding: 14px;
            border: none; border-radius: var(--radius);
            font-size: 16px; font-weight: 600;
            cursor: pointer; transition: all .15s;
            margin-top: 8px;
        }
        .btn-blue { background: var(--blue); color: #fff; }
        .btn-blue:hover { background: var(--blue-dark); }
        .btn-orange { background: var(--orange); color: #fff; }
        .btn-orange:hover { background: #D97706; }

        .auth-footer {
            margin-top: auto; padding-top: 40px;
            text-align: center;
            font-size: 13px; color: var(--gray-400);
        }
        .auth-footer a { color: var(--gray-500); text-decoration: none; }
        .auth-footer a:hover { color: var(--blue); }

        /* ── ERRORS ── */
        .alert-error {
            background: #FEF2F2; border: 1px solid #FECACA;
            border-radius: var(--radius-sm);
            padding: 12px 16px; margin-bottom: 20px;
            font-size: 14px; color: #991B1B;
        }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .auth-left { width: 100%; padding: 40px 24px; min-height: 220px; }
            .auth-right { padding: 32px 24px; }
            .auth-car-icon { width: 64px; height: 64px; margin-bottom: 16px; }
            .auth-left h1 { font-size: 22px; }
        }
    </style>
</head>
<body>
    <div class="auth-left">
        <div class="auth-left-content">
            <div class="auth-car-icon">
                <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="10" y="40" width="80" height="32" rx="8" stroke="rgba(255,255,255,0.8)" stroke-width="2.5"/>
                    <path d="M20 40 L30 20 H70 L80 40" stroke="rgba(255,255,255,0.8)" stroke-width="2.5" stroke-linejoin="round"/>
                    <circle cx="28" cy="74" r="10" stroke="rgba(255,255,255,0.8)" stroke-width="2.5"/>
                    <circle cx="72" cy="74" r="10" stroke="rgba(255,255,255,0.8)" stroke-width="2.5"/>
                    <circle cx="28" cy="74" r="3" fill="rgba(255,255,255,0.5)"/>
                    <circle cx="72" cy="74" r="3" fill="rgba(255,255,255,0.5)"/>
                    <rect x="38" y="25" width="24" height="14" rx="3" stroke="rgba(255,255,255,0.5)" stroke-width="1.5"/>
                    <rect x="12" y="52" width="12" height="3" rx="1.5" fill="rgba(255,255,255,0.6)"/>
                </svg>
            </div>
            <h1>Bienvenue sur AutoMoto</h1>
            <p>La plateforme numéro 1 pour acheter, vendre et comparer vos véhicules préférés.</p>
        </div>
    </div>

    <div class="auth-right">
        @yield('content')
    </div>
</body>
</html>
