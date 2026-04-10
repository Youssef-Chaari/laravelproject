@extends('layouts.admin')

@section('title', 'Détails Client : ' . $client->name)

@section('content')
<div class="page-header">
    <div>
        <h1>{{ $client->name }}</h1>
        <p>Inscrit le {{ $client->created_at->format('d/m/Y') }} – Email: {{ $client->email }}</p>
    </div>
    <div style="display:flex; gap:12px">
        <form action="{{ route('admin.clients.toggle', $client) }}" method="POST">
            @csrf
            @method('PATCH')
            @if($client->statut === 'actif')
                <button type="submit" class="btn" style="background:#FEE2E2; color:#991B1B">Désactiver le compte</button>
            @else
                <button type="submit" class="btn" style="background:#D1FAE5; color:#065F46">Réactiver le compte</button>
            @endif
        </form>
        <a href="{{ route('admin.clients.index') }}" class="btn btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<h2 style="font-size:20px; font-weight:700; margin-bottom:24px">Annonces Occasions postées ({{ $client->annonces->count() }})</h2>
    
    @if($client->annonces->count() > 0)
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Date</th>
                        <th>Prix</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($client->annonces as $annonce)
                        <tr>
                            <td style="font-weight:500">{{ $annonce->titre }}</td>
                            <td style="color:var(--gray-500)">{{ $annonce->created_at->format('d/m/Y') }}</td>
                            <td style="font-weight:600">{{ number_format($annonce->prix, 0, ',', ' ') }} €</td>
                            <td>
                                @if($annonce->statut === 'publie')
                                    <span class="status-badge status-active" style="padding:4px 8px;border-radius:4px;background:#D1FAE5;color:#065F46;font-size:12px;font-weight:600">Publiée</span>
                                @else
                                    <span class="status-badge" style="padding:4px 8px;border-radius:4px;background:var(--gray-100);color:var(--gray-600);font-size:12px;font-weight:600">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p style="color:var(--gray-500)">Ce client n'a publié aucune annonce d'occasion pour le moment.</p>
    @endif
</div>
@endsection
