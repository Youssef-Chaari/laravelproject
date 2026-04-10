@extends('layouts.app')
@section('title', 'Modifier l\'annonce')

@section('content')
<div class="bg-slate-50 min-h-screen py-12 border-t border-slate-200">
    <div class="max-w-3xl mx-auto px-4">
        
        <x-flash-message /> <!-- Added generic flash component placeholder if needed -->
        
        <div class="mb-10 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Modifier l'annonce</h1>
                <p class="text-slate-500 font-medium mt-2">Mettez à jour les informations de votre véhicule.</p>
            </div>
            <a href="{{ route('cars-used.my-ads') }}" class="btn-outline shadow-sm bg-white">Retour à mes annonces</a>
        </div>

        <form method="POST" action="{{ route('cars-used.update', $car) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')
            
            @include('cars-used._form', ['car' => $car])
            
            <div class="flex justify-end gap-4 mt-8 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <a href="{{ route('cars-used.show', $car) }}" class="btn-outline px-8 py-3">Annuler</a>
                <button type="submit" class="btn-primary px-8 py-3 shadow-md shadow-blue-500/20">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>
@endsection
