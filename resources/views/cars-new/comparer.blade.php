@extends('layouts.app')

@section('title', 'Comparer les véhicules – AutoMoto')

@push('styles')
<style>
    .page-body {
        max-width: 1200px;
        margin: 0 auto;
        padding: 36px 24px 80px;
    }
    
    .page-header {
        text-align: center;
        margin-bottom: 40px;
    }
    .page-header h1 {
        font-family: 'DM Serif Display', serif;
        font-size: 36px;
        color: var(--gray-900);
        margin-bottom: 12px;
    }
    .page-header p {
        font-size: 16px;
        color: var(--gray-500);
        max-width: 600px;
        margin: 0 auto;
    }

    /* ── SEARCH AREA ── */
    .compare-search {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-200);
        margin-bottom: 40px;
    }
    .compare-search-title {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 16px;
        color: var(--gray-900);
    }
    .search-flex {
        display: flex;
        gap: 16px;
        align-items: center;
    }
    .search-flex .form-select {
        flex: 1;
        padding: 12px 16px;
        background-color: var(--gray-50);
        font-size: 15px;
        font-weight: 500;
    }
    .btn-add {
        padding: 12px 24px;
        border-radius: var(--radius-sm);
        background: var(--blue);
        color: #fff;
        font-weight: 600;
        font-size: 15px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background .15s;
    }
    .btn-add:hover { background: var(--blue-dark); }
    .btn-add:disabled { background: var(--gray-300); cursor: not-allowed; }

    /* ── COMPARISON TABLE ── */
    .compare-wrapper {
        background: #fff;
        border-radius: 16px;
        border: 1px solid var(--gray-200);
        overflow-x: auto;
        box-shadow: var(--shadow);
    }
    .compare-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }
    .compare-table th, .compare-table td {
        padding: 20px;
        text-align: left;
        border-bottom: 1px solid var(--gray-100);
        border-right: 1px solid var(--gray-100);
        vertical-align: top;
    }
    .compare-table th:last-child, .compare-table td:last-child {
        border-right: none;
    }
    .compare-table tr:last-child td {
        border-bottom: none;
    }
    
    /* First Column (Labels) */
    .compare-table .col-label {
        width: 180px;
        background: var(--gray-50);
        font-weight: 600;
        color: var(--gray-700);
        font-size: 14px;
        border-right: 1px solid var(--gray-200);
    }

    /* Vehicle Headers */
    .vehicle-header {
        position: relative;
    }
    .btn-remove {
        position: absolute;
        top: 10px; right: 10px;
        width: 32px; height: 32px;
        border-radius: 8px;
        background: var(--gray-100);
        color: var(--gray-500);
        border: none;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: all .15s;
    }
    .btn-remove:hover { background: #FEE2E2; color: var(--red); }
    
    .vehicle-img-box {
        height: 140px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 64px;
        margin-bottom: 16px;
    }
    .vehicle-brand {
        font-size: 13px;
        font-weight: 600;
        color: var(--blue);
        margin-bottom: 4px;
    }
    .vehicle-name {
        font-size: 18px;
        font-weight: 700;
        color: var(--gray-900);
    }
    .vehicle-price {
        font-size: 18px;
        font-weight: 700;
        color: var(--gray-900);
        margin-top: 12px;
    }

    /* Specs Values */
    .spec-val {
        font-size: 15px;
        color: var(--gray-900);
        font-weight: 500;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 24px;
        background: #fff;
        border-radius: 16px;
        border: 1px dashed var(--gray-300);
    }
    .empty-state i {
        font-size: 48px;
        color: var(--gray-300);
        margin-bottom: 16px;
    }
    .empty-state p {
        font-size: 16px;
        color: var(--gray-500);
    }
</style>
@endpush

@section('content')

<main class="page-body">
    
    <div class="page-header">
        <h1>Comparer des véhicules</h1>
        <p>Sélectionnez jusqu'à 4 véhicules pour comparer en détail leurs caractéristiques techniques, prix et équipements.</p>
    </div>

    {{-- SEARCH & ADD --}}
    <div class="compare-search">
        <h2 class="compare-search-title">Ajouter un véhicule à comparer</h2>
        <form action="{{ route('comparer') }}" method="GET" class="search-flex" id="addCompareForm">
            @foreach($vehiculeIds as $id)
                <input type="hidden" name="ids[]" value="{{ $id }}">
            @endforeach
            
            <select class="form-select form-input" id="marqueSelect" onchange="updateModeles()">
                <option value="">1. Choisir une marque...</option>
                @foreach($allMarques as $marque)
                    <option value="{{ $marque->id }}">{{ $marque->nom }}</option>
                @endforeach
            </select>
            
            <select class="form-select form-input" id="modeleSelect" name="ids[]" disabled required>
                <option value="">2. Choisir un modèle...</option>
            </select>
            
            <button type="submit" class="btn-add" id="btnAdd" disabled>
                <i class="fa-solid fa-plus"></i>
                Ajouter
            </button>
        </form>
    </div>

    {{-- COMPARISON TABLE --}}
    @if($vehiculesToCompare->count() > 0)
        <div class="compare-wrapper">
            <table class="compare-table">
                <tbody>
                    <!-- Headers (Image + Title) -->
                    <tr>
                        <th class="col-label" style="vertical-align:bottom;padding-bottom:32px">
                            Modèle sélectionné
                        </th>
                        @foreach($vehiculesToCompare as $v)
                        <th class="vehicle-header">
                            <form action="{{ route('comparer') }}" method="GET">
                                @foreach($vehiculeIds as $id)
                                    @if($id != $v->id)
                                        <input type="hidden" name="ids[]" value="{{ $id }}">
                                    @endif
                                @endforeach
                                <button type="submit" class="btn-remove" title="Retirer">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </form>
                            
                            <div class="vehicle-img-box" style="background:{{ $v->couleur_bg ?? 'var(--gray-100)' }}">
                                <span>🚗</span>
                            </div>
                            <div class="vehicle-brand">{{ $v->marque->nom }}</div>
                            <div class="vehicle-name">{{ $v->modele }}</div>
                            <div class="vehicle-price">{{ number_format($v->prix, 0, ',', ' ') }} €</div>
                        </th>
                        @endforeach
                    </tr>

                    <!-- Specs Rows -->
                    <tr>
                        <td class="col-label">Année</td>
                        @foreach($vehiculesToCompare as $v)
                            <td class="spec-val">{{ $v->annee }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="col-label">Carburant</td>
                        @foreach($vehiculesToCompare as $v)
                            <td class="spec-val" style="text-transform:capitalize">{{ $v->carburant }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="col-label">Puissance</td>
                        @foreach($vehiculesToCompare as $v)
                            <td class="spec-val">{{ $v->puissance ? $v->puissance . ' ch' : '–' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="col-label">Transmission</td>
                        @foreach($vehiculesToCompare as $v)
                            <td class="spec-val" style="text-transform:capitalize">{{ $v->transmission }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="col-label">Consommation</td>
                        @foreach($vehiculesToCompare as $v)
                            <td class="spec-val">{{ $v->consommation ? $v->consommation . ' L/100km' : '–' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="col-label">Volume coffre</td>
                        @foreach($vehiculesToCompare as $v)
                            <td class="spec-val">{{ $v->volume_coffre ? $v->volume_coffre . ' L' : '–' }}</td>
                        @endforeach
                    </tr>
                    
                    <tr>
                        <td class="col-label">Équipements</td>
                        @foreach($vehiculesToCompare as $v)
                            <td class="spec-val">
                                @if($v->equipements && count($v->equipements) > 0)
                                    <ul style="padding-left:20px;margin:0;font-size:14px;color:var(--gray-700)">
                                    @foreach($v->equipements as $eq)
                                        <li style="margin-bottom:6px">{{ $eq }}</li>
                                    @endforeach
                                    </ul>
                                @else
                                    <span style="color:var(--gray-400)">Non spécifié</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    <!-- Action Row -->
                    <tr>
                        <td class="col-label" style="border-bottom:none"></td>
                        @foreach($vehiculesToCompare as $v)
                            <td style="border-bottom:none">
                                <a href="{{ route('voitures.show', [$v->marque->slug, $v->slug]) }}" class="btn btn-outline" style="width:100%">
                                    Voir détails
                                </a>
                            </td>
                        @endforeach
                    </tr>

                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <i class="fa-solid fa-code-compare"></i>
            <p>Veuillez sélectionner des véhicules ci-dessus pour lancer la comparaison.</p>
        </div>
    @endif

</main>

@endsection

@push('scripts')
<script>
    // Build an embedded JSON object mapping marque_id to an array of vehicules
    const vehiculesData = {
        @foreach($allMarques as $marque)
            "{{ $marque->id }}": [
                @foreach($marque->vehicules as $v)
                    { id: "{{ $v->id }}", name: "{{ addslashes($v->modele) }} ({{ $v->annee }})" },
                @endforeach
            ],
        @endforeach
    };

    function updateModeles() {
        const marqueId = document.getElementById('marqueSelect').value;
        const modeleSelect = document.getElementById('modeleSelect');
        const btnAdd = document.getElementById('btnAdd');
        
        // Reset
        modeleSelect.innerHTML = '<option value="">2. Choisir un modèle...</option>';
        
        if (marqueId && vehiculesData[marqueId]) {
            modeleSelect.disabled = false;
            vehiculesData[marqueId].forEach(v => {
                const opt = document.createElement('option');
                opt.value = v.id;
                opt.textContent = v.name;
                modeleSelect.appendChild(opt);
            });
        } else {
            modeleSelect.disabled = true;
            btnAdd.disabled = true;
        }
    }

    document.getElementById('modeleSelect').addEventListener('change', function() {
        document.getElementById('btnAdd').disabled = !this.value;
    });
</script>
@endpush
