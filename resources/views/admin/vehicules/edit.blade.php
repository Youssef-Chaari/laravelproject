@extends('layouts.admin')

@section('title', 'Modifier ' . $vehicule->modele)

@section('content')
<div class="page-header">
    <div>
        <h1>Modifier : {{ $vehicule->marque->nom }} {{ $vehicule->modele }}</h1>
        <p>Mise à jour d'une fiche véhicule existante.</p>
    </div>
    <a href="{{ route('admin.vehicules.index') }}" class="btn btn-outline">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>
</div>

<div class="form-card">
    <form action="{{ route('admin.vehicules.update', $vehicule) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px">
            <div class="form-group">
                <label class="form-label" for="marque_id">Marque</label>
                <select id="marque_id" name="marque_id" class="form-input" required>
                    @foreach($marques as $marque)
                        <option value="{{ $marque->id }}" {{ old('marque_id', $vehicule->marque_id) == $marque->id ? 'selected' : '' }}>
                            {{ $marque->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="modele">Modèle</label>
                <input type="text" id="modele" name="modele" class="form-input" required value="{{ old('modele', $vehicule->modele) }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="annee">Année</label>
                <input type="number" id="annee" name="annee" class="form-input" required min="1900" max="{{ date('Y') + 1 }}" value="{{ old('annee', $vehicule->annee) }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="prix">Prix (€)</label>
                <input type="number" id="prix" name="prix" class="form-input" required min="0" step="1" value="{{ old('prix', $vehicule->prix) }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="carburant">Carburant</label>
                <select id="carburant" name="carburant" class="form-input" required>
                    <option value="essence" {{ old('carburant', $vehicule->carburant) == 'essence' ? 'selected' : '' }}>Essence</option>
                    <option value="diesel" {{ old('carburant', $vehicule->carburant) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                    <option value="hybride" {{ old('carburant', $vehicule->carburant) == 'hybride' ? 'selected' : '' }}>Hybride</option>
                    <option value="electrique" {{ old('carburant', $vehicule->carburant) == 'electrique' ? 'selected' : '' }}>Électrique</option>
                    <option value="gpl" {{ old('carburant', $vehicule->carburant) == 'gpl' ? 'selected' : '' }}>GPL</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="transmission">Transmission</label>
                <select id="transmission" name="transmission" class="form-input" required>
                    <option value="manuelle" {{ old('transmission', $vehicule->transmission) == 'manuelle' ? 'selected' : '' }}>Manuelle</option>
                    <option value="automatique" {{ old('transmission', $vehicule->transmission) == 'automatique' ? 'selected' : '' }}>Automatique</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="puissance">Puissance (ch)</label>
                <input type="number" id="puissance" name="puissance" class="form-input" value="{{ old('puissance', $vehicule->puissance) }}" min="0" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="couple">Couple (Nm)</label>
                <input type="number" id="couple" name="couple" class="form-input" value="{{ old('couple', $vehicule->couple) }}" min="0">
            </div>

            <div class="form-group">
                <label class="form-label" for="consommation">Consommation (L/100km)</label>
                <input type="number" id="consommation" name="consommation" class="form-input" value="{{ old('consommation', $vehicule->consommation) }}" min="0" step="0.1">
            </div>

            <div class="form-group">
                <label class="form-label" for="nb_portes">Nb Portes</label>
                <input type="number" id="nb_portes" name="nb_portes" class="form-input" value="{{ old('nb_portes', $vehicule->nb_portes) }}" min="2" max="5">
            </div>

            <div class="form-group">
                <label class="form-label" for="nb_places">Nb Places</label>
                <input type="number" id="nb_places" name="nb_places" class="form-input" value="{{ old('nb_places', $vehicule->nb_places) }}" min="1" max="9">
            </div>

            <div class="form-group">
                <label class="form-label" for="volume_coffre">Volume Coffre (L)</label>
                <input type="number" id="volume_coffre" name="volume_coffre" class="form-input" value="{{ old('volume_coffre', $vehicule->volume_coffre) }}" min="0">
            </div>

            <div class="form-group">
                <label class="form-label" for="couleur">Couleur (nom)</label>
                <input type="text" id="couleur" name="couleur" class="form-input" value="{{ old('couleur', $vehicule->couleur) }}" placeholder="ex: Bleu Nuit">
            </div>

            <div class="form-group">
                <label class="form-label" for="couleur_bg">Couleur (Hex)</label>
                <input type="color" id="couleur_bg" name="couleur_bg" class="form-input" value="{{ old('couleur_bg', $vehicule->couleur_bg ?? '#3b82f6') }}" style="height:44px;padding:4px">
            </div>

            <div class="form-group">
                <label class="form-label" for="kilometrage">Kilométrage (si expo)</label>
                <input type="number" id="kilometrage" name="kilometrage" class="form-input" value="{{ old('kilometrage', $vehicule->kilometrage) }}" min="0">
            </div>

            <div class="form-group">
                <label class="form-label" for="garantie">Garantie (mois)</label>
                <input type="number" id="garantie" name="garantie" class="form-input" value="{{ old('garantie', $vehicule->garantie) }}" min="0">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="equipements">Équipements (séparés par des virgules)</label>
            <input type="text" id="equipements" name="equipements" class="form-input" value="{{ old('equipements', is_array($vehicule->equipements) ? implode(', ', $vehicule->equipements) : '') }}" placeholder="ex: GPS, Toit ouvrant, Sièges chauffants">
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Description</label>
            <textarea id="description" name="description" class="form-input" rows="4">{{ old('description', $vehicule->description) }}</textarea>
        </div>

        <div style="margin-top:32px;display:flex;justify-content:flex-end">
            <button type="submit" class="btn btn-primary">Mettre à jour le véhicule</button>
        </div>
    </form>
</div>
@endsection
