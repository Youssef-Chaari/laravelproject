@extends('layouts.admin')

@section('title', 'Gestion des Clients')

@section('content')

<div class="page-header">
    <div>
        <h1>Gestion des Clients</h1>
        <p>Liste des utilisateurs inscrits</p>
    </div>
    <input type="text"
           placeholder="Rechercher un client..."
           class="form-input"
           style="width:280px;padding:9px 14px;border:1px solid var(--gray-200);border-radius:var(--radius-sm);font-family:inherit;font-size:14px;outline:none"
           oninput="filterClients(this.value)">
</div>

<div class="table-card" id="clientsTable">
    <table>
        <thead>
            <tr>
                <th>Client</th>
                <th>Contact</th>
                <th>Inscription</th>
                <th>Annonces</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr class="client-row" data-name="{{ strtolower($client->name) }}" data-email="{{ strtolower($client->email) }}">
                <td>
                    <div style="display:flex;align-items:center;gap:12px">
                        <div style="width:38px;height:38px;border-radius:50%;background:var(--blue-light);color:var(--blue);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;flex-shrink:0">
                            {{ strtoupper(substr($client->name, 0, 2)) }}
                        </div>
                        <div>
                            <div style="font-weight:600;font-size:14px">{{ $client->name }}</div>
                            <div style="font-size:12px;color:var(--gray-400)">ID: #{{ $client->id }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div style="font-size:13px">{{ $client->email }}</div>
                    <div style="font-size:13px;color:var(--gray-500)">{{ $client->telephone ?? '–' }}</div>
                </td>
                <td style="font-size:13px;color:var(--gray-500)">
                    {{ $client->created_at->format('d/m/Y') }}
                </td>
                <td>
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;background:var(--gray-100);font-size:13px;font-weight:600">
                        {{ $client->annonces_count }}
                    </span>
                </td>
                <td>
                    @if($client->statut === 'actif')
                        <span class="badge status-active">Actif</span>
                    @else
                        <span class="badge status-inactive">Inactif</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex;gap:8px">
                        <a href="{{ route('admin.clients.show', $client->id) }}" class="btn-icon" title="Voir">
                            <i class="fa-regular fa-eye"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.clients.toggle', $client->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-icon" title="Activer / Désactiver">
                                <i class="fa-solid fa-ban" style="font-size:12px"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($clients->hasPages())
<div style="margin-top:20px;display:flex;justify-content:center">
    {{ $clients->links() }}
</div>
@endif

@endsection

@push('scripts')
<script>
function filterClients(query) {
    const rows = document.querySelectorAll('.client-row');
    rows.forEach(row => {
        const match = row.dataset.name.includes(query.toLowerCase())
                   || row.dataset.email.includes(query.toLowerCase());
        row.style.display = match ? '' : 'none';
    });
}
</script>
@endpush
