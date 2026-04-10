@extends('layouts.admin')
@section('title', 'Forum')
@section('page-title', 'Modération du Forum')
@section('page-subtitle', 'Gestion des sujets de discussion')

@section('content')
<div class="mb-6">
    <div class="bg-white p-1 rounded-lg border border-slate-200 shadow-sm inline-flex">
        <input type="text" placeholder="Rechercher un sujet ou auteur..." class="bg-transparent border-0 focus:ring-0 text-sm w-80 px-3" disabled>
        <button class="bg-slate-100 text-slate-500 rounded px-3 py-1 text-sm font-medium hover:bg-slate-200 transition">Chercher</button>
    </div>
</div>

<div class="bg-white border border-slate-200 shadow-sm rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="px-6 py-4">Sujet</th>
                    <th class="px-6 py-4">Auteur</th>
                    <th class="px-6 py-4">Réponses</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($topics as $topic)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900 truncate max-w-sm">{{ $topic->title }}</p>
                            <p class="text-slate-500 text-xs line-clamp-1 mt-1 font-medium">{{ Str::limit($topic->content, 60) }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-[10px] font-bold">
                                    {{ strtoupper(substr($topic->user->name, 0, 1)) }}
                                </div>
                                <span class="text-slate-700 font-medium">{{ $topic->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center justify-center bg-slate-100 text-slate-600 text-xs font-bold px-2 py-1 rounded border border-slate-200 min-w-[2rem]">
                                {{ $topic->comments_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs font-medium">{{ $topic->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('forum.show', $topic) }}" target="_blank" class="btn-outline text-xs px-3 py-1.5 bg-white border-slate-200 font-medium">Voir le sujet</a>
                                <form method="POST" action="{{ route('admin.forum.topic.destroy', $topic) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce sujet ainsi que toutes ses réponses ?')">
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
                                <svg class="w-10 h-10 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                <p class="font-medium text-slate-600">Aucun sujet de discussion trouvé.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6 bg-white p-4 rounded-xl shadow-sm border border-slate-200">
    {{ $topics->links() }}
</div>
@endsection
