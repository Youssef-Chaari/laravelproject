@extends('layouts.app')

@section('title', 'Mes Annonces – AutoMoto')

@push('styles')
<style>
    .myads-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 24px;
    }
    .myads-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .myads-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: var(--gray-900);
    }
    .btn-new-ad {
        background: var(--blue);
        color: #fff;
        padding: 10px 20px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-weight: 600;
        transition: background .15s;
    }
    .btn-new-ad:hover { background: var(--blue-dark); text-decoration: none;}
    
    .ads-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
    }
    .ad-card {
        background: #fff;
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .ad-img-box {
        height: 180px;
        background: var(--gray-100);
        position: relative;
    }
    .ad-img-box img {
        width: 100%; height: 100%;
        object-fit: cover;
    }
    .ad-status {
        position: absolute;
        top: 12px; right: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        box-shadow: var(--shadow);
    }
    .status-attente { background: #fef08a; color: #854d0e; }
    .status-publie { background: #dcfce7; color: #166534; }
    .status-rejete { background: #fee2e2; color: #991b1b; }
    
    .ad-body {
        padding: 16px;
        flex: 1;
    }
    .ad-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 4px;
    }
    .ad-meta {
        font-size: 14px;
        color: var(--gray-500);
        margin-bottom: 12px;
    }
    .ad-price {
        font-size: 18px;
        font-weight: 700;
        color: var(--orange);
    }
    
    .ad-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        border-top: 1px solid var(--gray-100);
    }
    .ad-actions a, .ad-actions button {
        padding: 12px;
        text-align: center;
        background: none; border: none;
        font-size: 14px; font-weight: 600;
        cursor: pointer; transition: background .15s;
        color: var(--gray-700); text-decoration: none;
    }
    .ad-actions a:hover, .ad-actions button:hover { background: var(--gray-50); }
    .btn-edit { color: var(--blue)!important; border-right: 1px solid var(--gray-100)!important; }
    .btn-delete { color: var(--red)!important; }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 12px;
        border: 1px dashed var(--gray-300);
    }
    .empty-state i { font-size: 48px; color: var(--gray-300); margin-bottom: 16px; }
    
    .alert-success { background: #dcfce7; color: #166534; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 500;}
</style>
@endpush

@section('content')

<div class="myads-container">
    <div class="myads-header">
        <h1>Mes annonces d'occasion</h1>
        <a href="{{ route('occasions.create') }}" class="btn-new-ad">
            <i class="fa-solid fa-plus"></i> Nouvelle annonce
        </a>
    </div>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($annonces->count() > 0)
        <div class="ads-grid">
            @foreach($annonces as $annonce)
                <div class="ad-card">
                    <div class="ad-img-box">
                        @if($annonce->images->count() > 0)
                            <img src="{{ asset('storage/' . $annonce->images->first()->path) }}" alt="{{ $annonce->modele }}">
                        @else
                            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:var(--gray-400)">
                                <i class="fa-solid fa-car fa-2x"></i>
                            </div>
                        @endif
                        
                        @if($annonce->statut === 'attente')
                            <span class="ad-status status-attente">En attente</span>
                        @elseif($annonce->statut === 'publie')
                            <span class="ad-status status-publie">Publiée</span>
                        @else
                            <span class="ad-status status-rejete">Rejetée</span>
                        @endif
                    </div>
                    
                    <div class="ad-body">
                        <div class="ad-title">{{ $annonce->titre }}</div>
                        <div class="ad-meta">{{ $annonce->annee }} • {{ number_format($annonce->kilometrage, 0, ',', ' ') }} km</div>
                        <div class="ad-price">{{ number_format($annonce->prix, 0, ',', ' ') }} €</div>
                    </div>
                    
                    <div class="ad-actions">
                        <a href="{{ route('occasions.edit', $annonce) }}" class="btn-edit">
                            <i class="fa-solid fa-pen"></i> Modifier
                        </a>
                        <form method="POST" action="{{ route('occasions.destroy', $annonce) }}" style="display:inline-block; width:100%">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" style="width:100%" onclick="return confirm('Spuprimer définitivement cette annonce ?')">
                                <i class="fa-solid fa-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fa-solid fa-car-side"></i>
            <h3>Vous n'avez aucune annonce</h3>
            <p style="color:var(--gray-500); margin-top:8px; margin-bottom: 24px;">Vos véhicules mis en vente apparaîtront ici.</p>
            <a href="{{ route('occasions.create') }}" class="btn-new-ad">Commencer à vendre</a>
        </div>
    @endif
</div>

@endsection
