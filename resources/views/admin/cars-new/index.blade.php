@extends('layouts.admin')
@section('title', 'Voitures Neuves')
@section('page-title', 'Catalogue Neuf')
@section('page-subtitle', 'Gérer les véhicules neufs de la plateforme')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div class="bg-white p-1 rounded-lg border border-slate-200 shadow-sm inline-flex">
        <input type="text" placeholder="Rechercher..." class="bg-transparent border-0 focus:ring-0 text-sm w-64 px-3" disabled>
        <button class="bg-slate-100 text-slate-500 rounded px-3 py-1 text-sm font-medium hover:bg-slate-200 transition">Chercher</button>
    </div>
    <a href="{{ route('admin.cars-new.create') }}" class="btn-primary flex items-center gap-2 shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Ajouter un véhicule
    </a>
</div>

<div class="bg-white border border-slate-200 shadow-sm rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="px-6 py-4">Véhicule</th>
                    <th class="px-6 py-4">Année</th>
                    <th class="px-6 py-4">Prix</th>
                    <th class="px-6 py-4">Carburant</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($cars as $car)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ $car->thumbnail ? Storage::url($car->thumbnail) : 'https://placehold.co/48x36/f8fafc/94a3b8?text=?' }}"
                                     class="w-14 h-10 object-cover rounded-lg border border-slate-200 shadow-sm">
                                <div>
                                    <p class="font-bold text-slate-900">{{ $car->brand }}</p>
                                    <p class="text-slate-500 text-xs font-medium">{{ $car->model }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $car->year }}</td>
                        <td class="px-6 py-4 text-slate-900 font-bold">{{ number_format($car->price, 0, ',', ' ') }} <span class="text-[10px] text-slate-400 font-bold uppercase">DH</span></td>
                        <td class="px-6 py-4 text-slate-600 capitalize">
                            <span class="inline-flex items-center gap-1.5 bg-slate-100 px-2 py-1 rounded-md text-xs font-medium border border-slate-200">
                                {{ $car->fuel_type }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.cars-new.edit', $car) }}" class="btn-outline text-xs px-3 py-1.5 bg-white border-slate-200 hover:border-slate-300">Modifier</a>
                                <form method="POST" action="{{ route('admin.cars-new.destroy', $car) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-danger text-xs px-3 py-1.5 bg-red-50 text-red-600 border-red-200 hover:bg-red-500 hover:text-white">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-10 h-10 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <p class="font-medium text-slate-600">Aucun véhicule neuf enregistré.</p>
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
