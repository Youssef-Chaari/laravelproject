@extends('layouts.app')
@section('title', ($annonce->marque->nom ?? 'Marque') . ' ' . $annonce->modele . ' – Occasion')

@section('content')
<div class="bg-slate-50 min-h-screen py-10 border-t border-slate-200">
    <div class="max-w-6xl mx-auto px-4">
        
        <x-flash-message /> <!-- Added generic flash component placeholder if needed -->

        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <a href="{{ route('cars-used.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 font-medium text-sm transition-colors bg-white px-4 py-2 rounded-lg border border-slate-200 hover:border-blue-200 shadow-sm w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour aux annonces
            </a>
            <div class="self-start sm:self-auto">
                <span class="badge-{{ $annonce->statut }} shadow-sm">{{ ucfirst($annonce->statut) }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Gallery Col --}}
            <div class="lg:col-span-7 space-y-4">
                @php
                    // Adjust this part based on how images are stored
                    // $images = $annonce->images; 
                    // $mainImage = $images->where('is_primary', true)->first() ?? $images->first();
                @endphp
                
                <div class="aspect-video rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shadow-sm relative group">
                    <img id="main-img"
                         src="https://placehold.co/800x450/f8fafc/94a3b8?text=Photo"
                         alt="{{ $annonce->marque->nom ?? '' }} {{ $annonce->modele }}"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/10 to-transparent pointer-events-none"></div>
                </div>
                
                {{-- Miniatures removed for now since photos handling is not fully implemented in DB --}}
            </div>

            {{-- Info Col --}}
            <div class="lg:col-span-5 relative">
                <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm lg:sticky lg:top-24">
                    <p class="inline-block bg-slate-100 text-slate-600 font-bold text-xs uppercase tracking-widest px-3 py-1 rounded-md mb-3 border border-slate-200">
                        {{ $annonce->marque->nom ?? 'Marque' }}
                    </p>
                    <h1 class="text-3xl lg:text-4xl font-black text-slate-900 leading-tight mb-8">{{ $annonce->modele }}</h1>

                    <div class="bg-orange-50 border border-orange-100 rounded-2xl p-5 mb-8 text-center flex flex-col items-center">
                        <span class="text-orange-500 font-black text-4xl mb-1">{{ number_format($annonce->prix, 0, ',', ' ') }}</span>
                        <span class="text-orange-600/80 font-bold text-sm uppercase tracking-wider">Dirhams</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="spec-card border p-3 rounded-xl">
                            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mb-1">Année</p>
                            <p class="font-bold text-slate-800 flex items-center gap-2">
                                <span>📅 {{ $annonce->annee }}</span>
                            </p>
                        </div>
                        <div class="spec-card border p-3 rounded-xl">
                            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mb-1">Kilométrage</p>
                            <p class="font-bold text-slate-800 flex items-center gap-2">
                                <span>🛣️ {{ number_format($annonce->kilometrage, 0, ',', ' ') }} km</span>
                            </p>
                        </div>
                        <div class="spec-card border p-3 rounded-xl">
                            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mb-1">Transmission</p>
                            <p class="font-bold text-slate-800 flex items-center gap-2">
                                <span>⚙️ {{ ucfirst($annonce->transmission ?? 'N/A') }}</span>
                            </p>
                        </div>
                        <div class="spec-card border p-3 rounded-xl">
                            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mb-1">Puissance (ch)</p>
                            <p class="font-bold text-slate-800 flex items-center gap-2">
                                <span>⚡ {{ $annonce->puissance ?? 'N/A' }} </span>
                            </p>
                        </div>
                    </div>

                    @if($annonce->description)
                        <div class="mb-8">
                            <h3 class="font-bold text-slate-900 border-b border-slate-100 pb-3 mb-4">Description</h3>
                            <div class="prose prose-slate prose-sm max-w-none text-slate-600 leading-relaxed">
                                {!! nl2br(e($annonce->description)) !!}
                            </div>
                        </div>
                    @endif

                    {{-- Seller Info --}}
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 mb-6">
                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mb-3">Vendeur Particulier</p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                                {{ strtoupper(substr($annonce->user->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-slate-900 truncate">{{ $annonce->user->name ?? 'Anonyme' }}</p>
                                <p class="text-xs font-medium text-slate-500">Publié {{ $annonce->created_at->diffForHumans() }}</p>
                            </div>
                            <a href="mailto:{{ $annonce->user->email ?? '' }}?subject=Intéressé(e) par votre {{ $annonce->marque->nom ?? '' }} {{ $annonce->modele }}" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-blue-600 hover:bg-blue-50 transition-colors shadow-sm" title="Envoyer un email">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </a>
                        </div>
                    </div>

                    {{-- Actions for Owner/Admin --}}
                    @auth
                        @if(auth()->id() === $annonce->user_id || auth()->user()->isAdmin())
                            <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3">
                                <a href="{{ route('occasions.index') }}" class="btn-outline flex-1 flex justify-center items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Modifier
                                </a>
                                <form method="POST" action="{{ route('occasions.index') }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cette annonce ?')" class="flex-1">
                                    @csrf @method('DELETE')
                                    <button class="btn-danger w-full flex justify-center items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
