@extends('layouts.app')

@section('title', 'Recherche de Voitures Neuves')

@push('styles')
<style>
    .page-body { max-width: 1200px; margin: 0 auto; padding: 24px 24px 64px; }

    .search-header { margin-bottom: 32px; }
    .search-header h1 { font-size: 28px; font-weight: 700; margin-bottom: 8px; }
    .search-header p { font-size: 15px; color: var(--gray-500); }

    /* ── FILTER FORM ── */
    .filter-bar {
        background: #fff;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius);
        padding: 24px; margin-bottom: 36px;
        display: flex; gap: 16px; align-items: flex-end;
    }
    .filter-group { flex: 1; }
    .filter-group label { display: block; font-size: 13px; font-weight: 600; color: var(--gray-700); margin-bottom: 6px; }
    .filter-group select, .filter-group input {
        width: 100%; padding: 11px 14px;
        border: 1px solid var(--gray-200); border-radius: var(--radius-sm);
        font-size: 14px; color: var(--gray-900); outline: none; background: #fff;
    }
    .filter-group select:focus, .filter-group input:focus { border-color: var(--blue); }
    .btn-filter {
        background: var(--blue); color: #fff;
        padding: 11px 24px; border-radius: var(--radius-sm);
        font-size: 14px; font-weight: 600; cursor: pointer;
        border: none; transition: background .15s;
        height: 42px; display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-filter:hover { background: var(--blue-dark); }
    
    @media (max-width: 768px) {
        .filter-bar { flex-direction: column; align-items: stretch; }
    }

    /* ── VEHICLES GRID ── */
    .vehicles-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
    .vehicle-card {
        background: #fff; border-radius: var(--radius);
        border: 1px solid var(--gray-200); overflow: hidden;
        text-decoration: none; color: inherit; transition: all .2s;
    }
    .vehicle-card:hover { border-color: var(--blue); box-shadow: 0 6px 20px rgba(37,99,235,.1); transform: translateY(-2px); }
    .vehicle-image { height: 180px; display: flex; align-items: center; justify-content: center; font-size: 72px; position: relative; }
    .vehicle-year { position: absolute; top: 12px; right: 12px; background: #fff; border-radius: 20px; padding: 3px 12px; font-size: 13px; font-weight: 600; color: var(--gray-700); box-shadow: 0 1px 4px rgba(0,0,0,.12); }
    .vehicle-brand { position: absolute; top: 12px; left: 12px; background: rgba(0,0,0,.6); color: #fff; border-radius: 20px; padding: 3px 10px; font-size: 12px; font-weight: 600; }
    .vehicle-info { padding: 16px 20px 20px; }
    .vehicle-name { font-size: 18px; font-weight: 700; margin-bottom: 8px; }
    .vehicle-specs { display: flex; gap: 16px; font-size: 13px; color: var(--gray-500); margin-bottom: 16px; }
    .vehicle-specs span { display: flex; align-items: center; gap: 5px; }
    .vehicle-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 14px; border-top: 1px solid var(--gray-100); }
    .vehicle-price { font-size: 20px; font-weight: 700; color: var(--blue); }
    .vehicle-link { display: flex; align-items: center; gap: 6px; font-size: 14px; font-weight: 600; color: var(--blue); }
    
    .empty { text-align: center; padding: 80px 20px; color: var(--gray-400); }
    .empty i { font-size: 48px; margin-bottom: 16px; display: block; }
    .pagination-wrapper { margin-top: 40px; }
    
    @media (max-width: 900px) { .vehicles-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px) { .vehicles-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div class="breadcrumb">
    <a href="{{ route('home') }}">Accueil</a>
    <span class="sep"><i class="fa-solid fa-chevron-right" style="font-size:10px"></i></span>
    <span class="current">Recherche Voitures Neuves</span>
</div>

<div class="page-body">
    <div class="search-header">
        <h1>Tous les modèles</h1>
        <p>{{ $vehicules->total() }} véhicule(s) trouvé(s) correspondant à vos critères.</p>
    </div>

    <form action="{{ route('voitures.index') }}" method="GET" class="filter-bar">
        <div class="filter-group" style="flex:1.5">
            <label>Modèle</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher un modèle (ex: A3)...">
        </div>
        <div class="filter-group">
            <label>Marque</label>
            <select name="marque">
                <option value="">Toutes les marques</option>
                @foreach($marques as $m)
                    <option value="{{ $m->id }}" {{ request('marque') == $m->id ? 'selected' : '' }}>{{ $m->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label>Budget max (€)</label>
            <select name="budget">
                <option value="">Peu importe</option>
                <option value="15000" {{ request('budget') == '15000' ? 'selected' : '' }}>15 000 €</option>
                <option value="25000" {{ request('budget') == '25000' ? 'selected' : '' }}>25 000 €</option>
                <option value="40000" {{ request('budget') == '40000' ? 'selected' : '' }}>40 000 €</option>
                <option value="60000" {{ request('budget') == '60000' ? 'selected' : '' }}>60 000 €</option>
                <option value="100000" {{ request('budget') == '100000' ? 'selected' : '' }}>100 000 €</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Carburant</label>
            <select name="carburant">
                <option value="">Tous les carburants</option>
                <option value="essence" {{ request('carburant') == 'essence' ? 'selected' : '' }}>Essence</option>
                <option value="diesel" {{ request('carburant') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                <option value="hybride" {{ request('carburant') == 'hybride' ? 'selected' : '' }}>Hybride</option>
                <option value="electrique" {{ request('carburant') == 'electrique' ? 'selected' : '' }}>Électrique</option>
            </select>
        </div>
        <button type="submit" class="btn-filter">
            <i class="fa-solid fa-magnifying-glass"></i> Filtrer
        </button>
        @if(request()->anyFilled(['marque', 'budget', 'carburant']))
            <a href="{{ route('voitures.index') }}" style="display:inline-flex; align-items:center; justify-content:center; height:42px; padding:0 16px; border-radius:8px; border:1px solid var(--gray-200); background:#fff; color:var(--gray-500); text-decoration:none; transition:.2s" title="Réinitialiser">
                <i class="fa-solid fa-rotate-right"></i>
            </a>
        @endif
    </form>

    @if($vehicules->isEmpty())
        <div class="empty">
            <i class="fa-regular fa-car-side"></i>
            <p>Aucun véhicule ne correspond à votre recherche.</p>
        </div>
    @else
        <div class="vehicles-grid">
            @foreach($vehicules as $vehicule)
            <a href="{{ route('voitures.show', [$vehicule->marque->slug, $vehicule->slug]) }}" class="vehicle-card">
                <div class="vehicle-image" style="background:{{ $vehicule->images->isNotEmpty() ? 'none' : ($vehicule->couleur_bg ?? 'linear-gradient(135deg,#EF4444,#B91C1C)') }}">
                    <span class="vehicle-brand">{{ $vehicule->marque->nom }}</span>
                    @if($vehicule->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $vehicule->images->first()->path) }}" alt="{{ $vehicule->modele }}" style="width:100%; height:100%; object-fit:cover">
                    @else
                        <span>🚗</span>
                    @endif
                    <span class="vehicle-year">{{ $vehicule->annee }}</span>
                </div>
                <div class="vehicle-info">
                    <div class="vehicle-name">{{ $vehicule->modele }}</div>
                    <div class="vehicle-specs">
                        <span><i class="fa-solid fa-gas-pump" style="color:var(--blue);font-size:12px"></i> {{ $vehicule->carburant }}</span>
                        <span><i class="fa-solid fa-bolt" style="color:var(--orange);font-size:12px"></i> {{ $vehicule->puissance }} ch</span>
                    </div>
                    <div class="vehicle-footer">
                        <span class="vehicle-price">{{ number_format($vehicule->prix, 0, ',', ' ') }} €</span>
                        <span class="vehicle-link">Voir la fiche <i class="fa-solid fa-chevron-right" style="font-size:12px"></i></span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="pagination-wrapper">
            {{ $vehicules->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
