@extends('layouts.app')

@section('title', 'Modifier le profil – AutoMoto')

@push('styles')
<style>
    .profile-container {
        max-width: 800px; margin: 48px auto 80px; padding: 0 24px;
    }
    .profile-header { margin-bottom: 32px; }
    .profile-header h1 { font-size: 28px; font-weight: 700; margin-bottom: 8px; }
    .profile-header p { color: var(--gray-500); font-size: 15px; }

    .profile-card {
        background: #fff; border-radius: var(--radius);
        border: 1px solid var(--gray-200); padding: 32px;
        margin-bottom: 24px;
        box-shadow: var(--shadow);
    }
    .profile-card h2 { font-size: 18px; font-weight: 600; margin-bottom: 24px; color: var(--gray-900); }
    
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    @media (max-width:640px) { .form-row { grid-template-columns: 1fr; } }
    
    .message-success { background: #D1FAE5; color: #065F46; padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 24px; font-weight: 500; font-size: 14px; }
    .error-text { color: var(--red); font-size: 13px; margin-top: 6px; display: block; }
</style>
@endpush

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Mon profil</h1>
        <p>Gérez vos informations personnelles et vos paramètres de sécurité.</p>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="message-success">Vos informations ont été mises à jour avec succès.</div>
    @endif
    @if (session('status') === 'password-updated')
        <div class="message-success">Votre mot de passe a été mis à jour avec succès.</div>
    @endif

    {{-- Info Form --}}
    <div class="profile-card">
        <h2>Informations personnelles</h2>
        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label" for="name">Nom complet</label>
                <input class="form-input" type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label" for="email">Adresse Email</label>
                <input class="form-input" type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div style="display:flex; justify-content:flex-end; margin-top:32px;">
                <button type="submit" class="btn btn-primary">Sauvegarder</button>
            </div>
        </form>
    </div>

    {{-- Pass Form --}}
    <div class="profile-card">
        <h2>Modifier le mot de passe</h2>
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label" for="current_password">Mot de passe actuel</label>
                <input class="form-input" type="password" id="current_password" name="current_password" required autocomplete="current-password">
                @error('current_password', 'updatePassword') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label" for="password">Nouveau mot de passe</label>
                    <input class="form-input" type="password" id="password" name="password" required autocomplete="new-password">
                    @error('password', 'updatePassword') <span class="error-text">{{ $message }}</span> @enderror
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label" for="password_confirmation">Confirmer modif.</label>
                    <input class="form-input" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                    @error('password_confirmation', 'updatePassword') <span class="error-text">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; margin-top:32px;">
                <button type="submit" class="btn btn-primary">Mettre à jour le mot de passe</button>
            </div>
        </form>
    </div>
</div>
@endsection
