@extends('layouts.admin')

@section('title', 'Ajouter une Marque')

@section('content')
<div class="page-header">
    <div>
        <h1>Ajouter une marque</h1>
        <p>Création d'une nouvelle marque automobile dans le système.</p>
    </div>
    <a href="{{ route('admin.marques.index') }}" class="btn btn-outline">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>
</div>

<div class="form-card" style="max-width:600px">
    <form action="{{ route('admin.marques.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label class="form-label" for="nom">Nom de la marque</label>
            <input type="text" id="nom" name="nom" class="form-input" required value="{{ old('nom') }}">
        </div>

        <div class="form-group">
            <label class="form-label" for="pays">Pays d'origine</label>
            <input type="text" id="pays" name="pays" class="form-input" value="{{ old('pays') }}">
        </div>

        <div class="form-group">
            <label class="form-label" for="couleur">Couleur de la marque (Hex)</label>
            <input type="color" id="couleur" name="couleur" class="form-input" style="height:48px;padding:4px" value="{{ old('couleur', '#2563EB') }}">
        </div>

        <div class="form-group">
            <label class="form-label" for="logo">Logo (Optionnel)</label>
            <input type="file" id="logo" name="logo" class="form-input" accept="image/*">
        </div>

        <div style="margin-top:32px;display:flex;justify-content:flex-end">
            <button type="submit" class="btn btn-primary">Enregistrer la marque</button>
        </div>
    </form>
</div>
@endsection
