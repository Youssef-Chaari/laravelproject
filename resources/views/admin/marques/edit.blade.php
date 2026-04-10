@extends('layouts.admin')

@section('title', 'Modifier la Marque ' . $marque->nom)

@section('content')
<div class="page-header">
    <div>
        <h1>Modifier : {{ $marque->nom }}</h1>
        <p>Mise à jour des informations de la marque.</p>
    </div>
    <a href="{{ route('admin.marques.index') }}" class="btn btn-outline">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>
</div>

<div class="form-card" style="max-width:600px">
    <form action="{{ route('admin.marques.update', $marque) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label" for="nom">Nom de la marque</label>
            <input type="text" id="nom" name="nom" class="form-input" required value="{{ old('nom', $marque->nom) }}">
        </div>

        <div class="form-group">
            <label class="form-label" for="pays">Pays d'origine</label>
            <input type="text" id="pays" name="pays" class="form-input" value="{{ old('pays', $marque->pays) }}">
        </div>

        <div class="form-group">
            <label class="form-label" for="couleur">Couleur de la marque (Hex)</label>
            <input type="color" id="couleur" name="couleur" class="form-input" style="height:48px;padding:4px" value="{{ old('couleur', $marque->couleur) }}">
        </div>

        <div class="form-group">
            <label class="form-label" for="logo">Nouveau Logo (laisser vide pour conserver l'actuel)</label>
            <input type="file" id="logo" name="logo" class="form-input" accept="image/*">
        </div>

        <div style="margin-top:32px;display:flex;justify-content:flex-end">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection
