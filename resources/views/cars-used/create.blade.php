@extends('layouts.app')

@section('title', 'Déposer une annonce – AutoMoto')

@push('styles')
<style>
    .occasions-header {
        max-width: 1200px; margin: 0 auto;
        padding: 28px 24px 0;
        display: flex; justify-content: center;
    }
    .tab-switch {
        display: inline-flex;
        background: var(--gray-100);
        border-radius: var(--radius); padding: 4px; gap: 4px;
    }
    .tab-switch a {
        padding: 10px 28px; border-radius: 9px;
        font-size: 15px; font-weight: 500;
        text-decoration: none; color: var(--gray-500);
        transition: all .2s;
    }
    .tab-switch a.active {
        background: var(--blue); color: #fff;
        box-shadow: 0 2px 6px rgba(37,99,235,.3);
    }

    .form-wrapper {
        max-width: 680px; margin: 28px auto 64px;
        padding: 0 24px;
    }
    .form-card {
        background: #fff; border-radius: 16px;
        border: 1px solid var(--gray-200);
        padding: 32px;
    }
    .form-card h2 { font-size: 22px; font-weight: 700; margin-bottom: 28px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { margin-bottom: 22px; }
    .form-label {
        display: block; font-size: 14px; font-weight: 500;
        color: var(--gray-700); margin-bottom: 7px;
    }
    .form-input, .form-select, .form-textarea {
        width: 100%; padding: 12px 14px;
        border: 1px solid var(--gray-200); border-radius: var(--radius-sm);
        font-size: 15px; font-family: inherit;
        color: var(--gray-900); outline: none;
        transition: border-color .15s;
    }
    .form-input::placeholder, .form-textarea::placeholder { color: var(--gray-400); }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(37,99,235,.1);
    }
    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 14px center;
        padding-right: 36px; cursor: pointer;
    }
    .form-textarea { resize: vertical; min-height: 100px; }

    /* ── PHOTO UPLOAD ── */
    .photo-upload {
        border: 2px dashed var(--gray-200);
        border-radius: var(--radius); padding: 36px 20px;
        text-align: center; cursor: pointer;
        transition: border-color .15s;
    }
    .photo-upload:hover { border-color: var(--blue); }
    .photo-upload i { font-size: 28px; color: var(--gray-400); margin-bottom: 10px; display: block; }
    .photo-upload p { font-size: 14px; color: var(--gray-500); }
    .photo-upload.dragover { border-color: var(--blue); background: var(--blue-light); opacity: 0.7; }

    /* ── PHOTO PREVIEW GRID ── */
    .photo-preview-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 16px; margin-top: 20px;
    }
    .preview-item {
        position: relative; aspect-ratio: 1;
        border-radius: 12px; overflow: hidden;
        border: 1px solid var(--gray-200);
        animation: scaleIn .2s ease-out;
    }
    @keyframes scaleIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }

    .preview-item img {
        width: 100%; height: 100%; object-fit: cover;
    }
    .remove-photo {
        position: absolute; top: 8px; right: 8px;
        width: 28px; height: 28px; border-radius: 50%;
        background: rgba(0,0,0,0.5); color: #fff;
        display: flex; align-items: center; justify-content: center;
        border: none; cursor: pointer; backdrop-filter: blur(4px);
        transition: all .2s;
    }
    .remove-photo:hover { background: var(--orange); transform: scale(1.1); }
    .remove-photo i { font-size: 13px; }

    /* ── SECTION LABEL ── */
    .section-label {
        font-size: 15px; font-weight: 700;
        color: var(--gray-900); margin-bottom: 16px;
        padding-bottom: 10px; border-bottom: 1px solid var(--gray-100);
    }

    .btn-publish {
        width: 100%; padding: 15px;
        background: var(--orange); color: #fff;
        border: none; border-radius: var(--radius);
        font-size: 16px; font-weight: 600;
        cursor: pointer; transition: background .15s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-publish:hover { background: var(--orange-dark); }
    
    /* ── ERROR STYLES ── */
    .error-msg { color: #ef4444; font-size: 13px; margin-top: 4px; font-weight: 500; }
    .form-input.is-invalid, .form-select.is-invalid, .form-textarea.is-invalid { border-color: #ef4444; }
    .alert { padding: 16px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500; }
    .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
</style>
@endpush

@section('content')

<div class="occasions-header">
    <div class="tab-switch">
        <a href="{{ route('occasions.index') }}">Voir les annonces</a>
        <a href="{{ route('occasions.create') }}" class="active">Déposer une annonce</a>
    </div>
</div>

<div class="form-wrapper">
    <div class="form-card">
        <h2>Vendez votre véhicule</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oups !</strong> Il y a quelques problèmes avec vos informations.
                <ul style="margin-top: 8px; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('occasions.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Marque / Modèle --}}
            <div class="form-group">
                <div class="form-row">
                    <div>
                        <label class="form-label">Marque</label>
                        <select name="marque_id" class="form-select" required>
                            <option value="">Sélectionner...</option>
                            @foreach($marques as $marque)
                                <option value="{{ $marque->id }}" {{ old('marque_id') == $marque->id ? 'selected' : '' }}>
                                    {{ $marque->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Modèle</label>
                        <input type="text" name="modele" class="form-input" placeholder="Ex: Clio, 208..." value="{{ old('modele') }}" required>
                    </div>
                </div>
            </div>

            {{-- Année / Kilométrage --}}
            <div class="form-group">
                <div class="form-row">
                    <div>
                        <label class="form-label">Année</label>
                        <input type="number" name="annee" class="form-input" placeholder="2021" min="1990" max="{{ date('Y') }}" value="{{ old('annee') }}" required>
                    </div>
                    <div>
                        <label class="form-label">Kilométrage</label>
                        <input type="number" name="kilometrage" class="form-input" placeholder="45000" value="{{ old('kilometrage') }}" required>
                    </div>
                </div>
            </div>

            {{-- Prix / Carburant --}}
            <div class="form-group">
                <div class="form-row">
                    <div>
                        <label class="form-label">Prix (€)</label>
                        <input type="number" name="prix" class="form-input" placeholder="15000" value="{{ old('prix') }}" required>
                    </div>
                    <div>
                        <label class="form-label">Carburant</label>
                        <select name="carburant" class="form-select" required>
                            <option value="essence" {{ old('carburant') == 'essence' ? 'selected' : '' }}>Essence</option>
                            <option value="diesel" {{ old('carburant') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="hybride" {{ old('carburant') == 'hybride' ? 'selected' : '' }}>Hybride</option>
                            <option value="electrique" {{ old('carburant') == 'electrique' ? 'selected' : '' }}>Électrique</option>
                            <option value="gpl" {{ old('carburant') == 'gpl' ? 'selected' : '' }}>GPL</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Transmission / Puissance --}}
            <div class="form-group">
                <div class="form-row">
                    <div>
                        <label class="form-label">Transmission</label>
                        <select name="transmission" class="form-select" required>
                            <option value="manuelle" {{ old('transmission') == 'manuelle' ? 'selected' : '' }}>Manuelle</option>
                            <option value="automatique" {{ old('transmission') == 'automatique' ? 'selected' : '' }}>Automatique</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Puissance (ch)</label>
                        <input type="number" name="puissance" class="form-input" placeholder="Ex: 110" value="{{ old('puissance') }}" required min="1">
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-textarea" placeholder="État du véhicule, options...">{{ old('description') }}</textarea>
            </div>

            {{-- Photos --}}
            <div class="form-group">
                <label class="form-label">Photos</label>
                <label class="photo-upload" id="drop-zone">
                    <input type="file" name="photos[]" id="photo-input" multiple accept="image/*" style="display:none">
                    <i class="fa-regular fa-camera"></i>
                    <p>Cliquez pour ajouter des photos</p>
                </label>
                <div id="photo-preview-grid" class="photo-preview-grid"></div>
            </div>

            {{-- Coordonnées --}}
            <div class="section-label">Vos coordonnées</div>
            <div class="form-group">
                <div class="form-row">
                    <div>
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-input" placeholder="Nom" value="{{ old('nom', auth()->user()->name ?? '') }}" required>
                    </div>
                    <div>
                        <label class="form-label">Téléphone</label>
                        <input type="tel" name="telephone" class="form-input @error('telephone') is-invalid @enderror" placeholder="06 12 34 56 78" value="{{ old('telephone') }}" required>
                        @error('telephone') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Ville</label>
                <input type="text" name="ville" class="form-input @error('ville') is-invalid @enderror" placeholder="Ex: Paris, Lyon..." value="{{ old('ville') }}" required>
                @error('ville') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn-publish">
                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                Publier l'annonce
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('photo-input');
    const grid = document.getElementById('photo-preview-grid');
    const dropZone = document.getElementById('drop-zone');

    let selectedFiles = [];

    // Sync DataTransfer to input
    function updateInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        input.files = dt.files;
    }

    function renderPreviews() {
        grid.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            const item = document.createElement('div');
            item.className = 'preview-item';

            reader.onload = function(e) {
                item.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    <button type="button" class="remove-photo" data-index="${index}">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                `;
            }
            reader.readAsDataURL(file);
            grid.appendChild(item);
        });
    }

    input.addEventListener('change', function(e) {
        const newFiles = Array.from(e.target.files);
        // Combine with existing files (optional, but usually users expect to append)
        selectedFiles = [...selectedFiles, ...newFiles].slice(0, 30); // Limit to 30
        updateInput();
        renderPreviews();
    });

    grid.addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.remove-photo');
        if (removeBtn) {
            const index = parseInt(removeBtn.getAttribute('data-index'));
            selectedFiles.splice(index, 1);
            updateInput();
            renderPreviews();
        }
    });

    // Drag & Drop visual effects
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            if (eventName === 'drop') {
                const droppedFiles = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
                selectedFiles = [...selectedFiles, ...droppedFiles].slice(0, 30);
                updateInput();
                renderPreviews();
            }
        });
    });
});
</script>
@endpush
