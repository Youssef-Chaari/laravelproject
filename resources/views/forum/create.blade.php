@extends('layouts.app')
@section('title', 'Nouveau sujet')

@section('content')
<div class="bg-slate-50 min-h-screen py-12 border-t border-slate-200">
    <div class="max-w-3xl mx-auto px-4">
        
        <x-flash-message />
        
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Lancer une discussion</h1>
            <p class="text-slate-500 font-medium mt-2">Partagez votre question, votre problème mécanique ou votre avis avec la communauté.</p>
        </div>

        <form method="POST" action="{{ route('forum.store') }}" class="bg-white border border-slate-200 shadow-sm rounded-3xl p-6 sm:p-10">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="form-label font-bold text-slate-800">Titre du sujet *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="form-input text-lg py-3" placeholder="ex: Quel avis sur le moteur 1.5 dCi ?">
                    <p class="text-xs text-slate-400 mt-2 font-medium">Soyez clair et précis pour obtenir de meilleures réponses.</p>
                    @error('title')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="form-label font-bold text-slate-800">Détails de votre sujet *</label>
                    <textarea name="content" rows="8" required class="form-input resize-y min-h-[150px]" placeholder="Bonjour, je voudrais avoir vos retours d'expérience sur...">{{ old('content') }}</textarea>
                    @error('content')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 mt-10 pt-6 border-t border-slate-100">
                <a href="{{ route('forum.index') }}" class="btn-outline px-8 py-3 text-center order-2 sm:order-1">Annuler</a>
                <button type="submit" class="btn-primary px-8 py-3 shadow-md shadow-blue-500/20 text-center order-1 sm:order-2">Publier le sujet</button>
            </div>
        </form>
    </div>
</div>
@endsection
