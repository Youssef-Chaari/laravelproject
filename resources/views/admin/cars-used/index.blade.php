@extends('layouts.admin')
@section('title', 'Annonces Occasion')
@section('page-title', 'Annonces d\'Occasion')
@section('page-subtitle', 'Modération et suivi des annonces entre particuliers')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex gap-2">
        <a href="#" class="btn-secondary text-sm px-4 py-2 border-orange-200 bg-orange-50 text-orange-700 shadow-sm">Tout voir</a>
        <a href="#" class="btn-outline text-sm px-4 py-2 border-slate-200 bg-white shadow-sm">En attente</a>
    </div>
    <div class="bg-white p-1 rounded-lg border border-slate-200 shadow-sm inline-flex">
        <input type="text" placeholder="Rechercher une annonce..." class="bg-transparent border-0 focus:ring-0 text-sm w-64 px-3" disabled>
        <button class="bg-slate-100 text-slate-500 rounded px-3 py-1 text-sm font-medium hover:bg-slate-200 transition">Chercher</button>
    </div>
</div>

<div class="bg-white border border-slate-200 shadow-sm rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="px-6 py-4">Annonce</th>
                    <th class="px-6 py-4">Vendeur</th>
                    <th class="px-6 py-4">Prix</th>
                    <th class="px-6 py-4">Statut</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($cars as $car)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <a href="{{ route('cars-used.show', $car) }}" target="_blank" class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors flex items-center gap-2">
                                    {{ $car->brand }} {{ $car->model }}
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                                <p class="text-slate-500 text-xs font-medium mt-1">{{ $car->year }} <span class="mx-1">•</span> {{ number_format($car->mileage, 0, ',', ' ') }} km</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">
                                    {{ strtoupper(substr($car->user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-slate-700">{{ $car->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-900 font-bold">{{ number_format($car->price, 0, ',', ' ') }} <span class="text-[10px] text-slate-400 font-bold uppercase">DH</span></td>
                        <td class="px-6 py-4">
                            <span class="badge-{{ $car->status }} shadow-sm">{{ ucfirst($car->status) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2 flex-wrap sm:flex-nowrap opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                @if($car->status !== 'approved')
                                    <form method="POST" action="{{ route('admin.cars-used.approve', $car) }}">
                                        @csrf @method('PATCH')
                                        <button class="text-xs px-3 py-1.5 bg-green-50 text-green-700 border border-green-200 rounded-lg hover:bg-green-600 hover:text-white transition shadow-sm font-medium tracking-wide">✓ Approuver</button>
                                    </form>
                                @endif
                                @if($car->status !== 'rejected')
                                    <form method="POST" action="{{ route('admin.cars-used.reject', $car) }}">
                                        @csrf @method('PATCH')
                                        <button class="text-xs px-3 py-1.5 bg-orange-50 text-orange-700 border border-orange-200 rounded-lg hover:bg-orange-600 hover:text-white transition shadow-sm font-medium tracking-wide">✗ Rejeter</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.cars-used.destroy', $car) }}" onsubmit="return confirm('Supprimer définitivement cette annonce ?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs px-3 py-1.5 bg-red-50 text-red-600 border border-red-200 rounded-lg hover:bg-red-500 hover:text-white transition shadow-sm font-medium tracking-wide">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-10 h-10 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="font-medium text-slate-600">Aucune annonce trouvée.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6 bg-white p-4 rounded-xl shadow-sm border border-slate-200">
    {{ $cars->links() }}
</div>
@endsection
