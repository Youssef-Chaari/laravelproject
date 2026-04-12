@extends('layouts.app')

@section('title', 'Modifier l\'annonce – AutoMoto')

@push('styles')
<style>
    .occasions-header {
        max-width: 1200px; margin: 0 auto;
        padding: 28px 24px 0;
        display: flex; justify-content: center;
    }
    .form-wrapper {
        max-width: 680px; margin: 28px auto 64px;
        padding: 0 24px;
    }
    .form-card {
        background: #fff; border-radius: 16px;
        border: 1px solid var(--gray-200);
        padding: 32px;
    }
    .form-card h2 { font-size: 22px; font-weight: 700; margin-bottom: 28px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { margin-bottom: 22px; }
    .form-label {
        display: block; font-size: 14px; font-weight: 500;
        color: var(--gray-700); margin-bottom: 7px;
    }
    .form-input, .form-select, .form-textarea {
        width: 100%; padding: 12px 14px;
        border: 1px solid var(--gray-200); border-radius: var(--radius-sm);
        font-size: 15px; font-family: inherit;
        color: var(--gray-900); outline: none;
        transition: border-color .15s;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: var(--blue); }
    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 14px center;
        padding-right: 36px; cursor: pointer;
    }
    .form-textarea { resize: vertical; min-height: 100px; }
    .section-label {
        font-size: 15px; font-weight: 700;
        color: var(--gray-900); margin-bottom: 16px;
        padding-bottom: 10px; border-bottom: 1px solid var(--gray-100);
    }
    .btn-publish {
        width: 100%; padding: 15px;
        background: var(--blue); color: #fff;
        border: none; border-radius: var(--radius);
        font-size: 16px; font-weight: 600;
        cursor: pointer; transition: background .15s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-publish:hover { background: var(--blue-dark); }
    .alert { padding: 16px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500; }
    .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    .alert-warning { background: #fef08a; color: #854d0e; border: 1px solid #fde047; }
</style>
@endpush

@section('content')

<div class="occasions-header">
    <a href="{{ route('occasions.myAds') }}" style="text-decoration:none; color:var(--blue); font-weight:600;">
        <i class="fa-solid fa-arrow-left"></i> Retour à mes annonces
    </a>
</div>

<div class="form-wrapper">
    <div class="form-card">
        <h2>Modifier votre annonce</h2>
        
        <div class="alert alert-warning">
            <i class="fa-solid fa-circle-info"></i> Toute modification repassera l'annonce en statut <strong>En attente</strong> de validation.
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oups !</strong> Il y a quelques problèmes avec vos informations.
                <ul style="margin-top: 8px; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('occasions.update', $annonce) }}">
            @csrf
            @method('PUT')

            {{-- Marque / Modèle --}}
            <div class="form-group">
                <div class="form-row">
                    <div>
                        <label class="form-label">Marque</label>
                        <select name="marque_id" class="form-select" required>
                            <option value="">Sélectionner...</option>
                            @foreach($marques as $marque)
                                <option value="{{ $marque->id }}" {{ old('marque_id', $annonce->marque_id) == $marque->id ? 'selected' : '' }}>
                                    {{ $marque->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Modèle</label>
                        <input type="text" name="modele" class="form-input" value="{{ old('modele', $annonce->modele) }}" required>
                    </div>
                </div>
            </div>

            {{-- Année / Kilométrage --}}
            <div class="form-group">
                <div class="form-row">
                    <div>
                        <label class="form-label">Année</label>
                        <input type="number" name="annee" class="form-input" min="1990" max="{{ date('Y') }}" value="{{ old('annee', $annonce->annee) }}" required>
                    </div>
                    <div>
                        <label class="form-label">Kilométrage</label>
                        <input type="number" name="kilometrage" class="form-input" value="{{ old('kilometrage', $annonce->kilometrage) }}" required>
                    </div>
                </div>
            </div>

            {{-- Prix / Carburant --}}
            <div class="form-group">
                <div class="form-row">
                    <div>
                        <label class="form-label">Prix (€)</label>
                        <input type="number" name="prix" class="form-input" value="{{ old('prix', round($annonce->prix)) }}" required>
                    </div>
                    <div>
                        <label class="form-label">Carburant</label>
                        <select name="carburant" class="form-select" required>
                            <option value="essence" {{ old('carburant', $annonce->carburant) == 'essence' ? 'selected' : '' }}>Essence</option>
                            <option value="diesel" {{ old('carburant', $annonce->carburant) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="hybride" {{ old('carburant', $annonce->carburant) == 'hybride' ? 'selected' : '' }}>Hybride</option>
                            <option value="electrique" {{ old('carburant', $annonce->carburant) == 'electrique' ? 'selected' : '' }}>Électrique</option>
                            <option value="gpl" {{ old('carburant', $annonce->carburant) == 'gpl' ? 'selected' : '' }}>GPL</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Transmission / Puissance --}}
            <div class="form-group">
                <div class="form-row">
                    <div>
                        <label class="form-label">Transmission</label>
                        <select name="transmission" class="form-select" required>
                            <option value="manuelle" {{ old('transmission', $annonce->transmission) == 'manuelle' ? 'selected' : '' }}>Manuelle</option>
                            <option value="automatique" {{ old('transmission', $annonce->transmission) == 'automatique' ? 'selected' : '' }}>Automatique</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Puissance (ch)</label>
                        <input type="number" name="puissance" class="form-input" value="{{ old('puissance', $annonce->puissance) }}" required min="1">
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-textarea">{{ old('description', $annonce->description) }}</textarea>
            </div>

            {{-- Coordonnées --}}
            <div class="section-label">Vos coordonnées</div>
            <div class="form-group">
                <div class="form-row">
                    <div>
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-input" value="{{ old('nom', $annonce->user->name ?? '') }}" required>
                    </div>
                    <div>
                        <label class="form-label">Téléphone</label>
                        <input type="tel" name="telephone" class="form-input" value="{{ old('telephone', $annonce->telephone) }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Ville</label>
                <input type="text" name="ville" class="form-input" value="{{ old('ville', $annonce->ville) }}" required>
            </div>

            <button type="submit" class="btn-publish">
                <i class="fa-solid fa-save"></i>
                Enregistrer les modifications
            </button>
        </form>
    </div>
</div>
@endsection
