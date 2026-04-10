@extends('layouts.app')
@section('title', 'Mes Annonces')

@section('content')
<div class="bg-slate-50 min-h-screen py-12 border-t border-slate-200">
    <div class="max-w-5xl mx-auto px-4">
        
        <x-flash-message /> <!-- generic flash component for errors/success -->

        <div class="flex flex-col sm:flex-row items-center justify-between mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Tableau de Bord / Mes Annonces</h1>
                <p class="text-slate-500 font-medium mt-1">Gérez vos véhicules mis en vente</p>
            </div>
            <a href="{{ route('cars-used.create') }}" class="btn-secondary shadow-md shadow-orange-500/20">+ Déposer une annonce</a>
        </div>

        @if($cars->isEmpty())
            <div class="bg-white border border-slate-200 shadow-sm rounded-3xl p-16 text-center">
                <div class="w-20 h-20 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">🚘</div>
                <h2 class="text-2xl font-bold text-slate-900 mb-3">Vous n'avez pas encore d'annonces</h2>
                <p class="text-slate-500 max-w-md mx-auto mb-8 font-medium">Commencez dès maintenant ! Publiez votre première annonce pour toucher des milliers d'acheteurs potentiels.</p>
                <a href="{{ route('cars-used.create') }}" class="btn-primary px-8 py-3 shadow-md shadow-blue-500/20">Vendre mon véhicule</a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($cars as $car)
                    <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-4 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center gap-5 hover:border-blue-300 transition-colors">
                        {{-- Image --}}
                        <a href="{{ route('cars-used.show', $car) }}" class="block w-full sm:w-48 h-32 flex-shrink-0 group relative rounded-xl overflow-hidden bg-slate-100">
                            @php $img = $car->primaryImage ?? $car->images->first(); @endphp
                            <img src="{{ $img ? Storage::url($img->path) : 'https://placehold.co/400x300/f8fafc/94a3b8?text=Photo' }}"
                                 alt="{{ $car->brand }} {{ $car->model }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 ring-1 ring-inset ring-black/10 rounded-xl"></div>
                        </a>
                        
                        {{-- Details --}}
                        <div class="flex-1 min-w-0 w-full">
                            <div class="flex flex-wrap items-center gap-3 mb-2">
                                <h3 class="font-bold text-slate-900 text-xl truncate">
                                    <a href="{{ route('cars-used.show', $car) }}" class="hover:text-blue-600 transition-colors">{{ $car->brand }} {{ $car->model }} <span class="text-slate-500 font-medium ml-1">{{ $car->year }}</span></a>
                                </h3>
                                <div class="ml-auto sm:ml-0">
                                    <span class="badge-{{ $car->status }} shadow-sm">{{ ucfirst($car->status) }}</span>
                                </div>
                            </div>
                            
                            <p class="text-orange-500 font-black text-xl mb-3">{{ number_format($car->price, 0, ',', ' ') }} <span class="text-xs font-semibold uppercase text-slate-400">DH</span></p>
                            
                            <div class="flex items-center gap-4 text-xs font-medium text-slate-500">
                                <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Publiée {{ $car->created_at->diffForHumans() }}</span>
                                <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> {{ $car->views ?? 0 }} vues</span>
                            </div>
                        </div>
                        
                        {{-- Actions --}}
                        <div class="flex flex-row sm:flex-col gap-2 w-full sm:w-auto mt-4 sm:mt-0 pt-4 sm:pt-0 border-t border-slate-100 sm:border-0">
                            <a href="{{ route('cars-used.edit', $car) }}" class="btn-outline text-sm w-full justify-center px-4 py-2 hover:bg-slate-50 border-slate-300">
                                Modifier
                            </a>
                            <form method="POST" action="{{ route('cars-used.destroy', $car) }}" onsubmit="return confirm('Attention ! Voulez-vous vraiment supprimer définitivement cette annonce ?')" class="w-full">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger text-sm w-full justify-center px-4 py-2 shadow-sm">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if($cars->hasPages())
            <div class="mt-10 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                {{ $cars->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
