@extends('layouts.admin')

@section('title', 'Modération des Occasions')

@section('content')
<div class="header">
    <div>
        <h1>Modération des Annonces</h1>
        <p>Validez, rejetez ou supprimez les annonces déposées par les utilisateurs.</p>
    </div>
</div>

<div class="table-card">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Auteur</th>
                <th>Véhicule</th>
                <th>Prix</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($annonces as $annonce)
                <tr>
                    <td>{{ $annonce->id }}</td>
                    <td>
                        <div style="font-weight:600">{{ $annonce->user->name ?? 'Inconnu' }}</div>
                        <div style="font-size:12px; color:var(--gray-500)">{{ $annonce->user->email ?? '' }}</div>
                    </td>
                    <td>
                        <div style="font-weight:600">{{ $annonce->titre }}</div>
                        <div style="font-size:12px; color:var(--gray-500)">{{ $annonce->kilometrage }} km - {{ $annonce->ville }}</div>
                    </td>
                    <td style="font-weight:600; color:var(--orange)">
                        {{ number_format($annonce->prix, 0, ',', ' ') }} €
                    </td>
                    <td>
                        {{ $annonce->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td>
                        @if($annonce->statut === 'attente')
                            <span class="badge badge-warning" style="background:#fef08a; color:#854d0e; padding:4px 8px; border-radius:12px; font-size:12px; font-weight:600;">En attente</span>
                        @elseif($annonce->statut === 'publie')
                            <span class="badge badge-success" style="background:#dcfce7; color:#166534; padding:4px 8px; border-radius:12px; font-size:12px; font-weight:600;">Publié</span>
                        @else
                            <span class="badge badge-danger" style="background:#fee2e2; color:#991b1b; padding:4px 8px; border-radius:12px; font-size:12px; font-weight:600;">Rejeté</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:8px;">
                            {{-- View Link --}}
                            <a href="{{ route('admin.annonces.show', $annonce) }}" class="btn btn-outline" style="padding:4px 8px; font-size:12px;" title="Voir l'annonce en détail">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            {{-- Actions conditionnelles selon le statut --}}
                            @if($annonce->statut === 'attente' || $annonce->statut === 'rejete')
                                <form action="{{ route('admin.annonces.valider', $annonce) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-primary" style="padding:4px 8px; font-size:12px; background:#10b981; border:none;" title="Valider">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                            @endif

                            @if($annonce->statut === 'attente' || $annonce->statut === 'publie')
                                <form action="{{ route('admin.annonces.rejeter', $annonce) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-primary" style="padding:4px 8px; font-size:12px; background:#f59e0b; border:none;" title="Rejeter">
                                        <i class="fa-solid fa-ban"></i>
                                    </button>
                                </form>
                            @endif

                            {{-- Delete action --}}
                            <form action="{{ route('admin.annonces.destroy', $annonce) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cette annonce ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding:4px 8px; font-size:12px;" title="Supprimer">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 32px; color: var(--gray-500)">
                        Aucune annonce dans le système.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">
    {{ $annonces->links() }}
</div>

@endsection
