@extends('layouts.app')

@section('title', 'AutoMoto – Trouvez la voiture de vos rêves')

@push('styles')
<style>
    /* ── HERO ── */
    .hero {
        background: linear-gradient(160deg, #0F2167 0%, #1E3A8A 45%, #1a2980 100%);
        padding: 80px 24px 100px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .hero::before {
        content: '';
        position: absolute; inset: 0;
        background: radial-gradient(ellipse at 20% 80%, rgba(99,102,241,.3) 0%, transparent 55%),
                    radial-gradient(ellipse at 80% 20%, rgba(37,99,235,.2) 0%, transparent 50%);
    }
    .hero-content { position: relative; max-width: 680px; margin: 0 auto; }
    .hero h1 {
        font-size: clamp(32px, 5vw, 52px);
        font-weight: 700; color: #fff;
        line-height: 1.15; margin-bottom: 18px;
    }
    .hero p {
        font-size: 17px; color: rgba(255,255,255,.78);
        line-height: 1.65; margin-bottom: 40px;
    }

    /* ── SEARCH BAR ── */
    .search-bar {
        background: #fff;
        border-radius: 16px;
        padding: 10px;
        display: flex; align-items: center; gap: 8px;
        box-shadow: 0 8px 32px rgba(0,0,0,.18);
        max-width: 760px; margin: 0 auto;
    }
    .search-bar select {
        flex: 1; padding: 11px 14px;
        border: none; background: var(--gray-50);
        border-radius: 10px;
        font-size: 15px; font-family: inherit;
        color: var(--gray-700);
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px;
        cursor: pointer; outline: none;
    }
    .search-bar .btn-search {
        background: var(--orange);
        color: #fff; border: none;
        padding: 12px 28px;
        border-radius: 10px;
        font-size: 15px; font-weight: 600;
        cursor: pointer; display: flex; align-items: center; gap: 8px;
        transition: background .15s;
        white-space: nowrap;
    }
    .search-bar .btn-search:hover { background: var(--orange-dark); }

    /* ── SECTION ── */
    .section { padding: 64px 0; }
    .section-header { margin-bottom: 32px; }
    .section-header h2 { font-size: 24px; font-weight: 700; margin-bottom: 6px; }
    .section-header p { font-size: 15px; color: var(--gray-500); }

    /* ── BRANDS GRID ── */
    .brands-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    .brand-card {
        background: #fff;
        border-radius: var(--radius);
        border: 1px solid var(--gray-200);
        padding: 20px;
        display: flex; flex-direction: column;
        gap: 12px;
        cursor: pointer; text-decoration: none;
        transition: all .2s;
    }
    .brand-card:hover {
        border-color: var(--blue);
        box-shadow: 0 4px 16px rgba(37,99,235,.12);
        transform: translateY(-2px);
    }
    .brand-card .avatar { border-radius: 10px; width: 48px; height: 48px; font-size: 20px; }
    .brand-card .brand-name { font-size: 16px; font-weight: 600; color: var(--gray-900); }
    .brand-card .brand-country { font-size: 13px; color: var(--gray-400); margin-top: 2px; }
    .brand-card .brand-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding-top: 12px; border-top: 1px solid var(--gray-100);
    }
    .brand-card .brand-count {
        font-size: 13px; font-weight: 600;
        color: var(--blue);
        background: var(--blue-light);
        padding: 3px 10px; border-radius: 20px;
    }
    .brand-card .brand-arrow { color: var(--gray-400); font-size: 14px; }

    /* ── WHY US ── */
    .why-section {
        background: var(--gray-100);
        border-top: 1px solid var(--gray-200);
        border-bottom: 1px solid var(--gray-200);
    }
    .why-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 32px;
        text-align: center;
    }
    .why-item { padding: 16px; }
    .why-icon {
        width: 64px; height: 64px;
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
        font-size: 26px;
    }
    .why-item h3 { font-size: 17px; font-weight: 700; margin-bottom: 10px; }
    .why-item p { font-size: 14px; color: var(--gray-500); line-height: 1.65; }

    /* ── BRAND AVATAR COLORS ── */
    .bg-toyota  { background: #EF4444; }
    .bg-bmw     { background: #2563EB; }
    .bg-merc    { background: #1F2937; }
    .bg-renault { background: #F59E0B; }
    .bg-peugeot { background: #2563EB; }
    .bg-audi    { background: #111827; }
    .bg-ford    { background: #2563EB; }
    .bg-vw      { background: #1D4ED8; }

    @media (max-width: 900px) {
        .brands-grid { grid-template-columns: repeat(2, 1fr); }
        .why-grid { grid-template-columns: 1fr; gap: 24px; }
    }
    @media (max-width: 600px) {
        .search-bar { flex-wrap: wrap; }
        .search-bar select { min-width: 100%; }
    }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="hero">
    <div class="hero-content">
        <h1>Trouvez la voiture de vos rêves</h1>
        <p>Comparez les meilleurs modèles, consultez les avis et trouvez la bonne affaire parmi des milliers d'annonces.</p>

        <form action="{{ route('voitures.index') }}" method="GET" class="search-bar">
            <select name="marque">
                <option value="">Toutes les marques</option>
                @foreach($marques as $marque)
                    <option value="{{ $marque->id }}">{{ $marque->nom }}</option>
                @endforeach
            </select>
            <select name="budget">
                <option value="">Budget max</option>
                <option value="15000">15 000 €</option>
                <option value="25000">25 000 €</option>
                <option value="40000">40 000 €</option>
                <option value="60000">60 000 €</option>
                <option value="100000">100 000 €</option>
            </select>
            <select name="carburant">
                <option value="">Carburant</option>
                <option value="essence">Essence</option>
                <option value="diesel">Diesel</option>
                <option value="hybride">Hybride</option>
                <option value="electrique">Électrique</option>
            </select>
            <button type="submit" class="btn-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                Rechercher
            </button>
        </form>
    </div>
</section>

{{-- BRANDS --}}
<div class="container">
    <section class="section">
        <div class="section-header">
            <h2>Voitures Neuves</h2>
            <p>Sélectionnez une marque pour explorer les modèles disponibles</p>
        </div>

        <div class="brands-grid">
            @foreach($marques as $marque)
            <a href="{{ route('voitures.marque', $marque->slug) }}" class="brand-card">
                <div class="avatar bg-{{ strtolower($marque->slug) }}">
                    {{ strtoupper(substr($marque->nom, 0, 1)) }}
                </div>
                <div>
                    <div class="brand-name">{{ $marque->nom }}</div>
                    <div class="brand-country">{{ $marque->pays }}</div>
                </div>
                <div class="brand-footer">
                    <span class="brand-count">{{ $marque->vehicules_count }} modèle{{ $marque->vehicules_count > 1 ? 's' : '' }}</span>
                    <i class="fa-solid fa-chevron-right brand-arrow"></i>
                </div>
            </a>
            @endforeach
        </div>
    </section>
</div>

{{-- WHY US --}}
<section class="why-section">
    <div class="container">
        <div class="section" style="padding-bottom:64px">
            <div class="section-header" style="text-align:center">
                <h2>Pourquoi nous choisir ?</h2>
            </div>
            <div class="why-grid">
                <div class="why-item">
                    <div class="why-icon" style="background:#EFF6FF;color:var(--blue)">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3>Garantie Certifiée</h3>
                    <p>Tous nos véhicules sont inspectés et garantis pour votre tranquillité.</p>
                </div>
                <div class="why-item">
                    <div class="why-icon" style="background:#ECFDF5;color:#059669">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <h3>Livraison à Domicile</h3>
                    <p>Recevez votre nouvelle voiture directement chez vous, partout en France.</p>
                </div>
                <div class="why-item">
                    <div class="why-icon" style="background:#FEF3C7;color:#D97706">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h3>Service Client 24/7</h3>
                    <p>Une équipe d'experts à votre écoute pour vous accompagner.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
