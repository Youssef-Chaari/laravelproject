@extends('layouts.admin')

@section('title', 'Gestion des Véhicules')

@push('styles')
<style>
    .vehicles-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }
    .admin-vehicle-card {
        background: #fff; border-radius: var(--radius);
        border: 1px solid var(--gray-200); overflow: hidden;
        transition: box-shadow .15s;
    }
    .admin-vehicle-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.08); }
    .vehicle-img {
        height: 160px; position: relative;
        display: flex; align-items: center; justify-content: center;
        font-size: 64px;
    }
    .vehicle-actions {
        position: absolute; top: 10px; right: 10px;
        display: flex; gap: 6px;
    }
    .vehicle-body { padding: 16px 18px 18px; }
    .vehicle-brand-tag {
        font-size: 12px; font-weight: 600; color: var(--blue);
        margin-bottom: 4px;
    }
    .vehicle-price-row {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 12px;
    }
    .vehicle-name { font-size: 17px; font-weight: 700; }
    .vehicle-price { font-size: 17px; font-weight: 700; }
    .vehicle-specs {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 4px; margin-bottom: 12px;
    }
    .spec-row { font-size: 13px; color: var(--gray-500); }
    .spec-row span { font-weight: 600; color: var(--gray-700); }
    .vehicle-tags { display: flex; flex-wrap: wrap; gap: 6px; }
    .equip-tag {
        font-size: 11px; font-weight: 500;
        background: var(--gray-100); color: var(--gray-600);
        padding: 3px 8px; border-radius: 6px;
    }
    .equip-more { color: var(--gray-400); font-size: 11px; font-weight: 600; }

    @media (max-width: 1100px) { .vehicles-grid { grid-template-columns: repeat(2,1fr); } }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h1>Gestion des Véhicules</h1>
        <p>Gérez votre inventaire automobile</p>
    </div>
    <div style="display:flex;gap:10px;align-items:center">
        <select class="form-select" style="padding:9px 14px;border:1px solid var(--gray-200);border-radius:var(--radius-sm);font-family:inherit;font-size:14px;outline:none;appearance:none;padding-right:32px;background-image:url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2712%27 height=%2712%27 viewBox=%270 0 12 12%27%3E%3Cpath fill=%27%236B7280%27 d=%27M6 8L1 3h10z%27/%3E%3C/svg%3E');background-repeat:no-repeat;background-position:right 10px center">
            <option value="">Toutes les marques</option>
            @foreach($marques as $marque)
                <option value="{{ $marque->id }}">{{ $marque->nom }}</option>
            @endforeach
        </select>
        <a href="{{ route('admin.vehicules.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            Ajouter
        </a>
    </div>
</div>

<div class="vehicles-grid">
    @foreach($vehicules as $vehicule)
    @php
        $colors = ['linear-gradient(135deg,#3B82F6,#1D4ED8)','linear-gradient(135deg,#F59E0B,#D97706)','linear-gradient(135deg,#374151,#1F2937)','linear-gradient(135deg,#2563EB,#1D4ED8)','linear-gradient(135deg,#EF4444,#B91C1C)','linear-gradient(135deg,#1F2937,#111827)'];
        $bg = $colors[$loop->index % count($colors)];
    @endphp
    <div class="admin-vehicle-card">
        <div class="vehicle-img" style="background:{{ $vehicule->couleur_bg ?? $bg }}">
            <span>🚗</span>
            <div class="vehicle-actions">
                <a href="{{ route('admin.vehicules.edit', $vehicule->id) }}" class="btn-icon">
                    <i class="fa-regular fa-pen-to-square"></i>
                </a>
                <form method="POST" action="{{ route('admin.vehicules.destroy', $vehicule->id) }}"
                      onsubmit="return confirm('Supprimer ce véhicule ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-icon danger">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="vehicle-body">
            <div class="vehicle-brand-tag">{{ $vehicule->marque->nom }}</div>
            <div class="vehicle-price-row">
                <span class="vehicle-name">{{ $vehicule->modele }}</span>
                <span class="vehicle-price">{{ number_format($vehicule->prix, 0, ',', ' ') }} €</span>
            </div>
            <div class="vehicle-specs">
                <div class="spec-row">Année: <span>{{ $vehicule->annee }}</span></div>
                <div class="spec-row"><span>{{ $vehicule->carburant }}</span></div>
                <div class="spec-row"><span>{{ $vehicule->puissance }} ch</span></div>
                <div class="spec-row"><span>{{ number_format($vehicule->kilometrage, 0, ',', ' ') }} km</span></div>
            </div>
            @if($vehicule->equipements && count($vehicule->equipements) > 0)
            <div class="vehicle-tags">
                @foreach(array_slice($vehicule->equipements, 0, 3) as $equip)
                    <span class="equip-tag">{{ $equip }}</span>
                @endforeach
                @if(count($vehicule->equipements) > 3)
                    <span class="equip-more">+{{ count($vehicule->equipements) - 3 }}</span>
                @endif
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>

@if($vehicules->hasPages())
<div style="margin-top:24px;display:flex;justify-content:center">
    {{ $vehicules->links() }}
</div>
@endif

@endsection
