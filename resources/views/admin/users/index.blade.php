@extends('layouts.admin')
@section('title', 'Utilisateurs')
@section('page-title', 'Gestion des Utilisateurs')
@section('page-subtitle', 'Liste des membres et administration des rôles')

@section('content')
<div class="mb-6">
    <div class="bg-white p-1 rounded-lg border border-slate-200 shadow-sm inline-flex">
        <input type="text" placeholder="Rechercher un utilisateur (email, nom)..." class="bg-transparent border-0 focus:ring-0 text-sm w-72 px-3" disabled>
        <button class="bg-slate-100 text-slate-500 rounded px-3 py-1 text-sm font-medium hover:bg-slate-200 transition">Chercher</button>
    </div>
</div>

<div class="bg-white border border-slate-200 shadow-sm rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="px-6 py-4">Utilisateur</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Rôle</th>
                    <th class="px-6 py-4">Inscription</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-xs font-bold text-white shadow-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <p class="font-bold text-slate-900">{{ $user->name }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-600">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if($user->isAdmin())
                                <span class="badge-approved shadow-sm px-2">Admin</span>
                            @else
                                <span class="inline-block px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-bold border border-slate-200">Utilisateur</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs font-medium">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.toggle-role', $user) }}">
                                        @csrf @method('PATCH')
                                        <button class="btn-outline text-xs px-3 py-1.5 bg-white border-slate-200 font-medium whitespace-nowrap">
                                            {{ $user->isAdmin() ? 'Rétrograder' : 'Promouvoir Admin' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce membre et tout son contenu (annonces, topics) ?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-danger text-xs px-3 py-1.5 bg-red-50 text-red-600 border-red-200 hover:bg-red-500 hover:text-white whitespace-nowrap">Supprimer</button>
                                    </form>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Vous
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            Aucun utilisateur trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6 bg-white p-4 rounded-xl shadow-sm border border-slate-200">
    {{ $users->links() }}
</div>
@endsection
