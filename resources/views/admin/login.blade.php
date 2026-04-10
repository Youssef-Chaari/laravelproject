<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoAdmin – Connexion</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --blue: #2563EB; --orange: #F59E0B; --orange-dark: #D97706;
            --gray-200: #E5E7EB; --gray-400: #9CA3AF; --gray-500: #6B7280;
        }
        body {
            font-family: 'DM Sans', sans-serif;
            background: #0F172A;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 24px;
        }
        .admin-card {
            background: #1E293B;
            border-radius: 20px;
            padding: 44px 40px;
            width: 100%; max-width: 460px;
            border: 1px solid rgba(255,255,255,.06);
        }
        .card-logo {
            width: 64px; height: 64px;
            background: var(--blue); border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 26px; color: #fff;
            margin: 0 auto 20px;
        }
        .card-title {
            font-size: 24px; font-weight: 700; color: #fff;
            text-align: center; margin-bottom: 8px;
        }
        .card-subtitle {
            font-size: 14px; color: rgba(255,255,255,.45);
            text-align: center; margin-bottom: 32px;
        }

        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block; font-size: 13px; font-weight: 500;
            color: rgba(255,255,255,.6); margin-bottom: 7px;
        }
        .form-input {
            width: 100%; padding: 13px 16px;
            background: #0F172A; border: 1px solid rgba(255,255,255,.1);
            border-radius: 10px;
            font-size: 15px; font-family: inherit;
            color: #fff; outline: none;
            transition: border-color .15s;
        }
        .form-input::placeholder { color: rgba(255,255,255,.3); }
        .form-input:focus { border-color: var(--blue); }

        .btn-submit {
            width: 100%; padding: 14px;
            background: var(--orange); color: #fff;
            border: none; border-radius: 10px;
            font-size: 16px; font-weight: 600;
            cursor: pointer; transition: background .15s;
            margin-top: 6px;
        }
        .btn-submit:hover { background: var(--orange-dark); }

        .back-link {
            display: block; text-align: center;
            margin-top: 24px;
            font-size: 13px; color: rgba(255,255,255,.35);
            text-decoration: none;
            transition: color .15s;
        }
        .back-link:hover { color: rgba(255,255,255,.6); }

        .alert-error {
            background: rgba(239,68,68,.15); border: 1px solid rgba(239,68,68,.3);
            border-radius: 8px; padding: 10px 14px;
            margin-bottom: 18px; font-size: 13px; color: #FCA5A5;
        }
    </style>
</head>
<body>
    <div class="admin-card">
        <div class="card-logo"><i class="fa-solid fa-car"></i></div>
        <h1 class="card-title">AutoAdmin</h1>
        <p class="card-subtitle">Accès réservé aux administrateurs</p>

        @if ($errors->any())
            <div class="alert-error">
                <i class="fa-solid fa-circle-exclamation" style="margin-right:6px"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input"
                    placeholder="admin@auto.com"
                    value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-input"
                    placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-submit">Se connecter</button>
        </form>

        <a href="{{ route('home') }}" class="back-link">
            ← Retour au site client
        </a>
    </div>
</body>
</html>
