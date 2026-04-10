@extends('layouts.app')

@section('title', 'Occasions – AutoMoto')

@push('styles')
<style>
    .occasions-header {
        max-width: 1200px; margin: 0 auto;
        padding: 28px 24px 0;
        display: flex; justify-content: center;
    }
    .tab-switch {
        display: inline-flex;
        background: var(--gray-100);
        border-radius: var(--radius);
        padding: 4px;
        gap: 4px;
    }
    .tab-switch a {
        padding: 10px 28px;
        border-radius: 9px;
        font-size: 15px; font-weight: 500;
        text-decoration: none; color: var(--gray-500);
        transition: all .2s;
    }
    .tab-switch a.active {
        background: var(--blue); color: #fff;
        box-shadow: 0 2px 6px rgba(37,99,235,.3);
    }

    /* ── SEARCH BAR ── */
    .occ-search {
        max-width: 1200px; margin: 24px auto 0;
        padding: 0 24px;
    }
    .occ-search-bar {
        background: #fff;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius);
        padding: 14px 20px;
        display: flex; align-items: center; gap: 16px;
    }
    .occ-search-input {
        flex: 1; border: none; outline: none;
        font-size: 15px; font-family: inherit;
        color: var(--gray-700);
    }
    .occ-search-input::placeholder { color: var(--gray-400); }
    .occ-divider { width: 1px; height: 24px; background: var(--gray-200); }
    .occ-select {
        border: none; outline: none;
        font-size: 15px; font-family: inherit;
        color: var(--gray-700); background: none;
        appearance: none; cursor: pointer;
        padding-right: 20px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right center;
    }

    /* ── CARDS GRID ── */
    .occ-grid {
        max-width: 1200px; margin: 28px auto 64px;
        padding: 0 24px;
        display: grid; grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .occ-card {
        background: #fff; border-radius: var(--radius);
        border: 1px solid var(--gray-200);
        overflow: hidden; transition: all .2s;
    }
    .occ-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,.1);
        transform: translateY(-2px);
    }
    .occ-image {
        height: 180px;
        display: flex; align-items: center; justify-content: center;
        font-size: 72px; position: relative;
    }
    .occ-date-badge {
        position: absolute; top: 12px; left: 12px;
        background: rgba(0,0,0,.55); color: #fff;
        font-size: 12px; font-weight: 600;
        padding: 4px 10px; border-radius: 6px;
    }
    .occ-body { padding: 16px 18px 18px; }
    .occ-title-row {
        display: flex; justify-content: space-between;
        align-items: flex-start; margin-bottom: 12px;
    }
    .occ-name { font-size: 17px; font-weight: 700; }
    .occ-price { font-size: 17px; font-weight: 700; color: var(--orange); white-space: nowrap; }
    .occ-specs {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 6px; margin-bottom: 14px;
    }
    .occ-spec {
        display: flex; align-items: center; gap: 6px;
        font-size: 13px; color: var(--gray-500);
    }
    .occ-spec i { color: var(--gray-400); font-size: 12px; width: 14px; }
    .occ-footer {
        display: flex; justify-content: space-between; align-items: center;
        padding-top: 12px; border-top: 1px solid var(--gray-100);
    }
    .occ-seller {
        display: flex; align-items: center; gap: 8px;
        font-size: 13px; color: var(--gray-700);
    }
    .seller-avatar {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: var(--blue-light); color: var(--blue);
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 700;
    }
    .btn-contact {
        font-size: 13px; font-weight: 600; color: var(--blue);
        text-decoration: none; transition: color .15s;
    }
    .btn-contact:hover { color: var(--blue-dark); }

    @media (max-width: 900px) { .occ-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px) { .occ-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

<div class="occasions-header">
    <div class="tab-switch">
        <a href="{{ route('occasions.index') }}" class="active">Voir les annonces</a>
        <a href="{{ route('occasions.create') }}">Déposer une annonce</a>
    </div>
</div>

<div class="occ-search">
    <form method="GET" action="{{ route('occasions.index') }}" class="occ-search-bar">
        <i class="fa-solid fa-magnifying-glass" style="color:var(--gray-400)"></i>
        <input type="text" name="q" class="occ-search-input" placeholder="Rechercher (ex: Peugeot 208)" value="{{ request('q') }}">
        <div class="occ-divider"></div>
        <select name="marque" class="occ-select" onchange="this.form.submit()">
            <option value="">Toutes marques</option>
            @foreach($marques as $marque)
                <option value="{{ $marque->id }}" {{ request('marque') == $marque->id ? 'selected' : '' }}>{{ $marque->nom }}</option>
            @endforeach
        </select>
        <div class="occ-divider"></div>
        <select name="prix_max" class="occ-select" onchange="this.form.submit()">
            <option value="">Prix max</option>
            <option value="10000" {{ request('prix_max') == '10000' ? 'selected' : '' }}>10 000 €</option>
            <option value="20000" {{ request('prix_max') == '20000' ? 'selected' : '' }}>20 000 €</option>
            <option value="30000" {{ request('prix_max') == '30000' ? 'selected' : '' }}>30 000 €</option>
            <option value="50000" {{ request('prix_max') == '50000' ? 'selected' : '' }}>50 000 €</option>
        </select>
        <button type="submit" style="background: var(--blue); color: #fff; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; margin-left: auto;">
            Rechercher
        </button>
    </form>
</div>

<div class="occ-grid">
    @foreach($annonces as $annonce)
    @php
        $colors = ['#3B82F6','#6B7280','#F97316','#1F2937','#6B7280','#EF4444'];
        $color = $colors[$loop->index % count($colors)];
    @endphp
    <div class="occ-card">
        <div class="occ-image" style="background:{{ $color }}">
            <span>🚙</span>
            <span class="occ-date-badge">{{ $annonce->date_relative }}</span>
        </div>
        <div class="occ-body">
            <div class="occ-title-row">
                <span class="occ-name">{{ $annonce->titre }}</span>
                <span class="occ-price">{{ number_format($annonce->prix, 0, ',', ' ') }} €</span>
            </div>
            <div class="occ-specs">
                <div class="occ-spec">
                    <i class="fa-solid fa-gauge-high"></i>
                    {{ number_format($annonce->kilometrage, 0, ',', ' ') }} km
                </div>
                <div class="occ-spec">
                    <i class="fa-regular fa-calendar"></i>
                    {{ $annonce->annee }}
                </div>
                <div class="occ-spec">
                    <i class="fa-solid fa-gas-pump"></i>
                    {{ $annonce->carburant }}
                </div>
                <div class="occ-spec">
                    <i class="fa-solid fa-location-dot"></i>
                    {{ $annonce->ville }}, FR
                </div>
            </div>
            <div class="occ-footer">
                <div class="occ-seller">
                    <div class="seller-avatar">{{ strtoupper(substr($annonce->vendeur_prenom, 0, 1)) }}</div>
                    {{ $annonce->vendeur_prenom }} {{ strtoupper(substr($annonce->vendeur_nom, 0, 1)) }}.
                </div>
                <a href="{{ route('occasions.show', $annonce->id) }}" class="btn-contact">Contacter</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
