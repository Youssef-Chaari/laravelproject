@extends('layouts.admin')

@section('title', 'Gestion des Marques')

@section('content')

<div class="page-header">
    <div>
        <h1>Gestion des Marques</h1>
        <p>Gérez le catalogue des constructeurs</p>
    </div>
    <a href="{{ route('admin.marques.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i>
        Ajouter une marque
    </a>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Logo</th>
                <th>Nom</th>
                <th>Pays</th>
                <th>Modèles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($marques as $marque)
            <tr>
                <td>
                    @if($marque->logo)
                        <img src="{{ asset('storage/'.$marque->logo) }}"
                             alt="{{ $marque->nom }}"
                             style="width:40px;height:40px;object-fit:contain;border-radius:8px;border:1px solid var(--gray-200)">
                    @else
                        <div style="width:40px;height:40px;border-radius:8px;background:{{ $marque->couleur ?? '#2563EB' }};display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:16px">
                            {{ strtoupper(substr($marque->nom, 0, 2)) }}
                        </div>
                    @endif
                </td>
                <td style="font-weight:600">{{ $marque->nom }}</td>
                <td style="color:var(--gray-500)">{{ $marque->pays }}</td>
                <td>
                    <span class="badge badge-blue">{{ $marque->vehicules_count }} modèle{{ $marque->vehicules_count > 1 ? 's' : '' }}</span>
                </td>
                <td>
                    <div style="display:flex;gap:8px">
                        <a href="{{ route('admin.marques.edit', $marque->id) }}" class="btn-icon" title="Modifier">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.marques.destroy', $marque->id) }}"
                              onsubmit="return confirm('Supprimer {{ $marque->nom }} ?')">
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

@if($marques->hasPages())
<div style="margin-top:20px;display:flex;justify-content:center">
    {{ $marques->links() }}
</div>
@endif

@endsection
