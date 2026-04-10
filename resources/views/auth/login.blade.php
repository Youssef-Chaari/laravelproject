@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
    <a href="{{ route('home') }}" class="auth-back">
        <i class="fa-solid fa-arrow-left" style="font-size:13px"></i>
        Retour
    </a>

    <h2>Connexion</h2>
    <p class="subtitle">Heureux de vous revoir !</p>

    <div class="auth-tabs">
        <a href="{{ route('login') }}" class="auth-tab active">Connexion</a>
        <a href="{{ route('register') }}" class="auth-tab">Inscription</a>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <i class="fa-solid fa-circle-exclamation" style="margin-right:6px"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                class="form-input"
                placeholder="exemple@email.com"
                value="{{ old('email') }}"
                required
                autofocus
            >
        </div>

        <div class="form-group">
            <label class="form-label" for="password">
                Mot de passe
                <a href="{{ route('password.request') }}">Oublié ?</a>
            </label>
            <input
                id="password"
                type="password"
                name="password"
                class="form-input"
                placeholder="••••••••"
                required
            >
        </div>

        <button type="submit" class="btn-submit btn-blue">
            Se connecter
        </button>
    </form>

    <div class="auth-footer">
        <a href="{{ route('admin.login') }}">Accès administration</a>
    </div>
@endsection
