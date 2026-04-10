@extends('layouts.app')

@section('title', $marque->nom . ' – Voitures Neuves')

@push('styles')
<style>
    .page-body { max-width: 1200px; margin: 0 auto; padding: 24px 24px 64px; }

    /* ── BRAND HEADER ── */
    .brand-header {
        display: flex; align-items: center; gap: 20px;
        margin-bottom: 36px;
    }
    .back-btn {
        width: 36px; height: 36px;
        border-radius: 50%; border: 1px solid var(--gray-200);
        background: #fff; display: flex; align-items: center; justify-content: center;
        color: var(--gray-500); text-decoration: none;
        transition: all .15s; flex-shrink: 0;
    }
    .back-btn:hover { border-color: var(--blue); color: var(--blue); }
    .brand-avatar {
        width: 72px; height: 72px;
        border-radius: 16px; color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 30px; font-weight: 700;
        flex-shrink: 0;
    }
    .brand-header-info h1 { font-size: 26px; font-weight: 700; }
    .brand-header-info p { font-size: 15px; color: var(--gray-500); margin-top: 4px; }

    /* ── VEHICLES GRID ── */
    .vehicles-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .vehicle-card {
        background: #fff;
        border-radius: var(--radius);
        border: 1px solid var(--gray-200);
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        transition: all .2s;
    }
    .vehicle-card:hover {
        border-color: var(--blue);
        box-shadow: 0 6px 20px rgba(37,99,235,.1);
        transform: translateY(-2px);
    }

    .vehicle-image {
        height: 180px;
        display: flex; align-items: center; justify-content: center;
        font-size: 72px;
        position: relative;
    }
    .vehicle-year {
        position: absolute; top: 12px; right: 12px;
        background: #fff; border-radius: 20px;
        padding: 3px 12px;
        font-size: 13px; font-weight: 600;
        color: var(--gray-700);
        box-shadow: 0 1px 4px rgba(0,0,0,.12);
    }

    .vehicle-info { padding: 16px 20px 20px; }
    .vehicle-name { font-size: 18px; font-weight: 700; margin-bottom: 8px; }
    .vehicle-specs {
        display: flex; gap: 16px;
        font-size: 13px; color: var(--gray-500);
        margin-bottom: 16px;
    }
    .vehicle-specs span { display: flex; align-items: center; gap: 5px; }
    .vehicle-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding-top: 14px; border-top: 1px solid var(--gray-100);
    }
    .vehicle-price {
        font-size: 20px; font-weight: 700; color: var(--blue);
    }
    .vehicle-link {
        display: flex; align-items: center; gap: 6px;
        font-size: 14px; font-weight: 600; color: var(--blue);
    }

    /* ── EMPTY STATE ── */
    .empty { text-align: center; padding: 80px 20px; color: var(--gray-400); }
    .empty i { font-size: 48px; margin-bottom: 16px; display: block; }

    @media (max-width: 900px) { .vehicles-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px) { .vehicles-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

{{-- BREADCRUMB --}}
<div class="breadcrumb">
    <a href="{{ route('voitures.index') }}">Voitures Neuves</a>
    <span class="sep"><i class="fa-solid fa-chevron-right" style="font-size:10px"></i></span>
    <span class="current">{{ $marque->nom }}</span>
</div>

<div class="page-body">

    {{-- BRAND HEADER --}}
    <div class="brand-header">
        <a href="{{ route('voitures.index') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left" style="font-size:14px"></i>
        </a>
        <div class="brand-avatar" style="background:{{ $marque->couleur ?? '#2563EB' }}">
            {{ strtoupper(substr($marque->nom, 0, 1)) }}
        </div>
        <div class="brand-header-info">
            <h1>{{ $marque->nom }}</h1>
            <p>{{ $marque->pays }} · {{ $vehicules->count() }} modèle{{ $vehicules->count() > 1 ? 's' : '' }} disponible{{ $vehicules->count() > 1 ? 's' : '' }}</p>
        </div>
    </div>

    {{-- VEHICLES --}}
    @if($vehicules->isEmpty())
        <div class="empty">
            <i class="fa-regular fa-car-side"></i>
            <p>Aucun véhicule disponible pour cette marque.</p>
        </div>
    @else
        <div class="vehicles-grid">
            @foreach($vehicules as $vehicule)
            <a href="{{ route('voitures.show', [$marque->slug, $vehicule->slug]) }}" class="vehicle-card">
                <div class="vehicle-image" style="background:{{ $vehicule->couleur_bg ?? 'linear-gradient(135deg,#EF4444,#B91C1C)' }}">
                    <span>🚗</span>
                    <span class="vehicle-year">{{ $vehicule->annee }}</span>
                </div>
                <div class="vehicle-info">
                    <div class="vehicle-name">{{ $vehicule->modele }}</div>
                    <div class="vehicle-specs">
                        <span>
                            <i class="fa-solid fa-gas-pump" style="color:var(--blue);font-size:12px"></i>
                            {{ $vehicule->carburant }}
                        </span>
                        <span>
                            <i class="fa-solid fa-bolt" style="color:var(--orange);font-size:12px"></i>
                            {{ $vehicule->puissance }} ch
                        </span>
                    </div>
                    <div class="vehicle-footer">
                        <span class="vehicle-price">{{ number_format($vehicule->prix, 0, ',', ' ') }} €</span>
                        <span class="vehicle-link">
                            Voir la fiche
                            <i class="fa-solid fa-chevron-right" style="font-size:12px"></i>
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
