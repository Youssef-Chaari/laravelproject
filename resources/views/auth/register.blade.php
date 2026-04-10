@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')
    <a href="{{ route('home') }}" class="auth-back">
        <i class="fa-solid fa-arrow-left" style="font-size:13px"></i>
        Retour
    </a>

    <h2>Créer un compte</h2>
    <p class="subtitle">Rejoignez notre communauté de passionnés.</p>

    <div class="auth-tabs">
        <a href="{{ route('login') }}" class="auth-tab">Connexion</a>
        <a href="{{ route('register') }}" class="auth-tab active">Inscription</a>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <i class="fa-solid fa-circle-exclamation" style="margin-right:6px"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <div class="form-row">
                <div>
                    <label class="form-label" for="first_name">Prénom</label>
                    <input
                        id="first_name"
                        type="text"
                        name="first_name"
                        class="form-input"
                        placeholder="Jean"
                        value="{{ old('first_name') }}"
                        required autofocus
                    >
                </div>
                <div>
                    <label class="form-label" for="last_name">Nom</label>
                    <input
                        id="last_name"
                        type="text"
                        name="last_name"
                        class="form-input"
                        placeholder="Dupont"
                        value="{{ old('last_name') }}"
                        required
                    >
                </div>
            </div>
        </div>

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
            >
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Mot de passe</label>
            <input
                id="password"
                type="password"
                name="password"
                class="form-input"
                placeholder="••••••••"
                required
            >
        </div>

        <button type="submit" class="btn-submit btn-orange">
            Créer mon compte
        </button>
    </form>

    <div class="auth-footer">
        <a href="{{ route('admin.login') }}">Accès administration</a>
    </div>
@endsection

