@extends('layouts.admin')

@section('title', 'Détails de l\'annonce – Modération')

@section('content')
<div class="header" style="margin-bottom: 24px; display:flex; align-items:center; justify-content:space-between">
    <div>
        <a href="{{ route('admin.annonces.index') }}" style="color:var(--gray-500); text-decoration:none; font-size:14px; font-weight:600; display:flex; align-items:center; gap:8px"><i class="fa-solid fa-arrow-left"></i> Retour à la modération</a>
        <h1 style="margin-top:12px;">{{ $annonce->titre }}</h1>
    </div>
    
    <div style="display:flex; gap:12px;">
        @if($annonce->statut === 'attente' || $annonce->statut === 'rejete')
            <form action="{{ route('admin.annonces.valider', $annonce) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-primary" style="background:#10b981; border:none;">
                    <i class="fa-solid fa-check"></i> Valider et Publier
                </button>
            </form>
        @endif
        @if($annonce->statut === 'attente' || $annonce->statut === 'publie')
            <form action="{{ route('admin.annonces.rejeter', $annonce) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-primary" style="background:#f59e0b; border:none;">
                    <i class="fa-solid fa-ban"></i> Rejeter
                </button>
            </form>
        @endif
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    {{-- Main Column --}}
    <div style="display:flex; flex-direction:column; gap:24px;">
        {{-- Images --}}
        <div class="card" style="padding:24px;">
            <h3 style="font-size:16px; margin-bottom:16px;">Photos ({{ $annonce->images->count() }})</h3>
            <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:12px;">
                @forelse($annonce->images as $image)
                    <img src="{{ asset('storage/' . $image->path) }}" alt="Photo" style="width:100%; aspect-ratio:4/3; object-fit:cover; border-radius:8px; border:1px solid var(--gray-200);">
                @empty
                    <div style="grid-column: 1/-1; padding:32px; text-align:center; background:var(--gray-50); border-radius:8px; color:var(--gray-500);">Aucune photo fournie.</div>
                @endforelse
            </div>
        </div>

        {{-- Description --}}
        <div class="card" style="padding:24px;">
            <h3 style="font-size:16px; margin-bottom:16px;">Description par le vendeur</h3>
            <div style="font-size:15px; color:var(--gray-700); line-height:1.6; white-space:pre-wrap;">{{ $annonce->description ?? 'Aucune description fournie.' }}</div>
        </div>
    </div>

    {{-- Side Column --}}
    <div style="display:flex; flex-direction:column; gap:24px;">
        {{-- Statut --}}
        <div class="card" style="padding:24px; text-align:center;">
            <div style="font-size:13px; color:var(--gray-500); font-weight:600; margin-bottom:8px; text-transform:uppercase; letter-spacing:1px;">Statut actuel</div>
            @if($annonce->statut === 'attente')
                <span style="display:inline-block; background:#fef08a; color:#854d0e; padding:6px 14px; border-radius:20px; font-size:16px; font-weight:700;">En attente</span>
            @elseif($annonce->statut === 'publie')
                <span style="display:inline-block; background:#dcfce7; color:#166534; padding:6px 14px; border-radius:20px; font-size:16px; font-weight:700;">Publié</span>
            @else
                <span style="display:inline-block; background:#fee2e2; color:#991b1b; padding:6px 14px; border-radius:20px; font-size:16px; font-weight:700;">Rejeté</span>
            @endif
        </div>

        {{-- Prix --}}
        <div class="card" style="padding:24px; text-align:center; background:var(--orange); color:#fff; border:none;">
            <div style="font-size:13px; font-weight:600; opacity:0.9; margin-bottom:4px;">Prix demandé</div>
            <div style="font-size:32px; font-weight:800;">{{ number_format($annonce->prix, 0, ',', ' ') }} €</div>
        </div>

        {{-- Infos Véhicule --}}
        <div class="card" style="padding:24px;">
            <h3 style="font-size:16px; margin-bottom:16px;">Spécifications techniques</h3>
            <table style="width:100%; border-collapse:collapse; font-size:14px;">
                <tr><td style="padding:10px 0; border-bottom:1px solid var(--gray-100); color:var(--gray-500)">Marque</td><td style="padding:10px 0; border-bottom:1px solid var(--gray-100); text-align:right; font-weight:600">{{ $annonce->marque->nom ?? 'N/A' }}</td></tr>
                <tr><td style="padding:10px 0; border-bottom:1px solid var(--gray-100); color:var(--gray-500)">Modèle</td><td style="padding:10px 0; border-bottom:1px solid var(--gray-100); text-align:right; font-weight:600">{{ $annonce->modele }}</td></tr>
                <tr><td style="padding:10px 0; border-bottom:1px solid var(--gray-100); color:var(--gray-500)">Année</td><td style="padding:10px 0; border-bottom:1px solid var(--gray-100); text-align:right; font-weight:600">{{ $annonce->annee }}</td></tr>
                <tr><td style="padding:10px 0; border-bottom:1px solid var(--gray-100); color:var(--gray-500)">Kilométrage</td><td style="padding:10px 0; border-bottom:1px solid var(--gray-100); text-align:right; font-weight:600">{{ number_format($annonce->kilometrage, 0, ',', ' ') }} km</td></tr>
                <tr><td style="padding:10px 0; border-bottom:1px solid var(--gray-100); color:var(--gray-500)">Carburant</td><td style="padding:10px 0; border-bottom:1px solid var(--gray-100); text-align:right; font-weight:600; text-transform:capitalize">{{ $annonce->carburant }}</td></tr>
                <tr><td style="padding:10px 0; border-bottom:1px solid var(--gray-100); color:var(--gray-500)">Transmission</td><td style="padding:10px 0; border-bottom:1px solid var(--gray-100); text-align:right; font-weight:600; text-transform:capitalize">{{ $annonce->transmission }}</td></tr>
                <tr><td style="padding:10px 0; color:var(--gray-500)">Puissance</td><td style="padding:10px 0; text-align:right; font-weight:600">{{ $annonce->puissance }} ch</td></tr>
            </table>
        </div>

        {{-- Infos Vendeur --}}
        <div class="card" style="padding:24px;">
            <h3 style="font-size:16px; margin-bottom:16px;">Identité du Vendeur</h3>
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                <div style="width:40px; height:40px; border-radius:50%; background:var(--blue-light); color:var(--blue); display:flex; align-items:center; justify-content:center; font-weight:700;">
                    {{ strtoupper(substr($annonce->user->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight:700">{{ $annonce->user->name ?? 'Vendeur Anonyme' }}</div>
                    <div style="font-size:13px; color:var(--gray-500);">Compte ID: {{ $annonce->user_id }}</div>
                </div>
            </div>
            <div style="font-size:14px; margin-bottom:8px;"><i class="fa-solid fa-envelope" style="width:20px; color:var(--gray-400)"></i> {{ $annonce->user->email ?? 'N/A' }}</div>
            <div style="font-size:14px; margin-bottom:8px;"><i class="fa-solid fa-phone" style="width:20px; color:var(--gray-400)"></i> {{ $annonce->telephone }}</div>
            <div style="font-size:14px;"><i class="fa-solid fa-location-dot" style="width:20px; color:var(--gray-400)"></i> {{ $annonce->ville }}</div>
        </div>
    </div>
</div>
@endsection
