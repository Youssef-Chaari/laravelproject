@extends('layouts.admin')

@section('title', 'Modération Forum')

@section('content')

<div class="page-header">
    <div>
        <h1>Modération du Forum</h1>
        <p>Gérez les sujets de discussion et supprimez les contenus inappropriés</p>
    </div>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Sujet</th>
                <th>Auteur</th>
                <th>Réponses</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topics as $topic)
            <tr>
                <td style="max-width: 400px;">
                    <div style="font-weight:600; color:var(--gray-900); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ $topic->title }}
                    </div>
                    <div style="font-size:12px; color:var(--gray-400); margin-top:2px;">
                        {{ \Illuminate\Support\Str::limit($topic->content, 80) }}
                    </div>
                </td>
                <td>
                    <div style="display:flex; align-items:center; gap:8px">
                        <div style="width:24px; height:24px; border-radius:50%; background:var(--blue-light); color:var(--blue); display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:700">
                            {{ strtoupper(substr($topic->user->name ?? 'A', 0, 1)) }}
                        </div>
                        <span style="font-size:14px">{{ $topic->user->name ?? 'Anonyme' }}</span>
                    </div>
                </td>
                <td>
                    <span class="badge badge-blue">{{ $topic->comments_count }}</span>
                </td>
                <td style="color:var(--gray-500); font-size:13px">{{ $topic->created_at->format('d/m/Y') }}</td>
                <td>
                    <div style="display:flex; gap:8px">
                        <a href="{{ route('forum.show', $topic->id) }}" class="btn-icon" title="Voir" target="_blank">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.forum.topic.destroy', $topic->id) }}"
                              onsubmit="return confirm('Supprimer ce sujet ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-icon danger" title="Supprimer">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($topics->hasPages())
<div style="margin-top:20px; display:flex; justify-content:center">
    {{ $topics->links() }}
</div>
@endif

@endsection

