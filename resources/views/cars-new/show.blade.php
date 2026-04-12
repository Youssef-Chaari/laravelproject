@extends('layouts.app')

@section('title', $marque->nom . ' ' . $vehicule->modele . ' ' . $vehicule->annee)

@push('styles')
<style>
    .page-body { max-width: 1200px; margin: 0 auto; padding: 24px 24px 64px; }

    .back-link {
        display: inline-flex; align-items: center; gap: 7px;
        font-size: 14px; font-weight: 500;
        color: var(--gray-500); text-decoration: none;
        margin-bottom: 28px;
        transition: color .15s;
    }
    .back-link:hover { color: var(--blue); }

    /* ── LAYOUT ── */
    .detail-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 28px;
        align-items: start;
    }

    /* ── GALLERY ── */
    .gallery-main {
        border-radius: 16px; overflow: hidden;
        position: relative;
        height: 340px;
        display: flex; align-items: center; justify-content: center;
        font-size: 120px;
        background: linear-gradient(135deg, #EF4444, #B91C1C);
    }
    .gallery-counter {
        position: absolute; bottom: 16px; right: 16px;
        background: rgba(0,0,0,.55); color: #fff;
        font-size: 13px; font-weight: 600;
        padding: 5px 12px; border-radius: 20px;
    }
    .gallery-nav {
        position: absolute; top: 50%; transform: translateY(-50%);
        width: 36px; height: 36px;
        background: rgba(255,255,255,.9);
        border-radius: 50%; border: none;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; font-size: 14px; color: var(--gray-700);
        transition: background .15s;
    }
    .gallery-nav:hover { background: #fff; }
    .gallery-nav.prev { left: 14px; }
    .gallery-nav.next { right: 14px; }
    .gallery-thumbs {
        display: flex; gap: 10px; margin-top: 12px;
    }
    .gallery-thumb {
        flex: 1; height: 72px;
        border-radius: 10px; overflow: hidden;
        background: var(--gray-200);
        border: 2px solid transparent;
        cursor: pointer; transition: border-color .15s;
    }
    .gallery-thumb.active { border-color: var(--blue); }
    .gallery-thumb img { width: 100%; height: 100%; object-fit: cover; }

    /* ── DESCRIPTION / EQUIPEMENTS ── */
    .info-card {
        background: #fff; border-radius: var(--radius);
        border: 1px solid var(--gray-200);
        padding: 24px; margin-top: 20px;
    }
    .info-card h3 { font-size: 16px; font-weight: 700; margin-bottom: 14px; }
    .info-card p { font-size: 14px; color: var(--gray-600); line-height: 1.7; }
    .equip-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .equip-item {
        display: flex; align-items: center; gap: 8px;
        font-size: 14px; color: var(--gray-700);
    }
    .equip-item i { color: #10B981; font-size: 13px; }

    /* ── SIDEBAR ── */
    .sidebar-card {
        background: #fff; border-radius: var(--radius);
        border: 1px solid var(--gray-200);
        padding: 24px;
        position: sticky; top: 80px;
    }
    .brand-badge {
        display: inline-flex; align-items: center;
        padding: 4px 12px; border-radius: 20px;
        background: var(--blue-light); color: var(--blue);
        font-size: 13px; font-weight: 600;
        margin-bottom: 12px;
    }
    .sidebar-card h2 {
        font-size: 24px; font-weight: 700; margin-bottom: 4px;
    }
    .sidebar-card .year-fuel {
        font-size: 14px; color: var(--gray-500); margin-bottom: 20px;
    }
    .price-label { font-size: 13px; color: var(--gray-500); margin-bottom: 4px; }
    .price-big {
        font-size: 32px; font-weight: 700; color: var(--blue);
        margin-bottom: 20px;
    }
    .btn-devis {
        width: 100%; padding: 14px;
        background: var(--orange); color: #fff;
        border: none; border-radius: var(--radius);
        font-size: 15px; font-weight: 600;
        cursor: pointer; transition: background .15s;
        margin-bottom: 12px;
    }
    .btn-devis:hover { background: var(--orange-dark); }
    .btn-compare {
        width: 100%; padding: 12px;
        background: none; color: var(--gray-700);
        border: none; border-radius: var(--radius);
        font-size: 14px; font-weight: 500;
        cursor: pointer; transition: color .15s;
    }
    .btn-compare:hover { color: var(--blue); }

    /* ── SPECS ── */
    .specs-section {
        margin-top: 20px; padding-top: 20px;
        border-top: 1px solid var(--gray-100);
    }
    .specs-section h3 { font-size: 14px; font-weight: 700; margin-bottom: 14px; }
    .specs-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    .spec-item {}
    .spec-label {
        font-size: 12px; color: var(--gray-400);
        display: flex; align-items: center; gap: 5px;
        margin-bottom: 3px;
    }
    .spec-value { font-size: 14px; font-weight: 600; color: var(--gray-900); }

    /* ── TECH SHEET ── */
    .tech-sheet {
        background: #fff; border-radius: var(--radius);
        border: 1px solid var(--gray-200);
        overflow: hidden; margin-top: 20px;
    }
    .tech-sheet h3 { font-size: 16px; font-weight: 700; padding: 20px 24px 14px; }
    .tech-row {
        display: flex; justify-content: space-between;
        padding: 12px 24px;
        border-top: 1px solid var(--gray-100);
        font-size: 14px;
    }
    .tech-row:first-of-type { border-top: none; }
    .tech-key { color: var(--gray-500); }
    .tech-val { font-weight: 600; color: var(--gray-900); }

    @media (max-width: 960px) {
        .detail-layout { grid-template-columns: 1fr; }
        .sidebar-card { position: static; }
    }

    /* ── COMPARE TOAST ── */
    .compare-toast {
        position: fixed;
        bottom: 28px; left: 50%; transform: translateX(-50%);
        background: #111827;
        color: #fff;
        border-radius: 14px;
        padding: 14px 22px;
        display: flex; align-items: center; gap: 14px;
        font-size: 14px; font-weight: 500;
        box-shadow: 0 8px 30px rgba(0,0,0,.25);
        z-index: 2000;
        opacity: 0; pointer-events: none;
        transition: opacity .25s, bottom .25s;
        white-space: nowrap;
    }
    .compare-toast.show { opacity: 1; pointer-events: all; bottom: 36px; }
    .compare-toast a {
        background: #2563eb;
        color: #fff;
        padding: 7px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: background .15s;
    }
    .compare-toast a:hover { background: #1d4ed8; }
    .compare-toast .toast-dismiss {
        cursor: pointer; opacity: 0.6;
        font-size: 18px; line-height: 1;
        background: none; border: none; color: #fff;
    }
    .compare-toast .toast-dismiss:hover { opacity: 1; }

    /* ── DEVIS MODAL ── */
    .modal-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(0,0,0,.55);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    .modal-overlay.open { display: flex; }
    .modal-box {
        background: #fff;
        border-radius: 20px;
        width: 100%;
        max-width: 520px;
        box-shadow: 0 20px 60px rgba(0,0,0,.2);
        overflow: hidden;
        animation: slideUp .25s ease;
    }
    @keyframes slideUp {
        from { transform: translateY(30px); opacity: 0; }
        to   { transform: translateY(0); opacity: 1; }
    }
    .modal-header {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        padding: 24px 28px;
        color: #fff;
        display: flex; justify-content: space-between; align-items: flex-start;
    }
    .modal-header h3 { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
    .modal-header p { font-size: 13px; opacity: 0.8; }
    .modal-close {
        background: rgba(255,255,255,.2); border: none; color: #fff;
        width: 32px; height: 32px; border-radius: 50%;
        font-size: 16px; cursor: pointer; flex-shrink: 0; margin-left: 12px;
        display: flex; align-items: center; justify-content: center;
        transition: background .15s;
    }
    .modal-close:hover { background: rgba(255,255,255,.35); }
    .modal-body { padding: 28px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
    .form-group { margin-bottom: 14px; }
    .form-group:last-child { margin-bottom: 0; }
    .modal-body textarea.form-input { resize: vertical; min-height: 80px; }
    .btn-submit-devis {
        width: 100%; padding: 14px;
        background: #f59e0b; color: #fff;
        border: none; border-radius: 12px;
        font-size: 15px; font-weight: 700;
        cursor: pointer; transition: background .15s;
        margin-top: 18px;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-submit-devis:hover { background: #d97706; }
    .modal-car-info {
        background: #eff6ff; border-radius: 10px; padding: 12px 16px;
        margin-bottom: 20px; font-size: 13px;
        display: flex; align-items: center; gap: 10px;
    }
    .modal-car-info i { color: #1e40af; font-size: 18px; }
    .modal-car-info strong { color: #1e40af; }
</style>
@endpush

@section('content')

<div class="breadcrumb">
    <a href="{{ route('voitures.index') }}">Voitures Neuves</a>
    <span class="sep"><i class="fa-solid fa-chevron-right" style="font-size:10px"></i></span>
    <a href="{{ route('voitures.marque', $marque->slug) }}">{{ $marque->nom }}</a>
    <span class="sep"><i class="fa-solid fa-chevron-right" style="font-size:10px"></i></span>
    <span class="current">{{ $vehicule->modele }}</span>
</div>

<div class="page-body">
    <a href="{{ route('voitures.marque', $marque->slug) }}" class="back-link">
        <i class="fa-solid fa-arrow-left" style="font-size:13px"></i>
        Retour aux modèles {{ $marque->nom }}
    </a>

    <div class="detail-layout">

        {{-- LEFT: GALLERY + INFO --}}
        <div>
            <div class="gallery-wrapper">
                <div class="gallery-main" style="background:{{ $vehicule->images->isNotEmpty() ? 'none' : ($vehicule->couleur_bg ?? 'linear-gradient(135deg,#EF4444,#B91C1C)') }}">
                    @if($vehicule->images->isNotEmpty())
                        <img id="main-img" src="{{ asset('storage/' . $vehicule->images->first()->path) }}" alt="{{ $vehicule->modele }}" style="width:100%; height:100%; object-fit:cover; transition: opacity 0.2s;">
                        
                        @if($vehicule->images->count() > 1)
                            <button class="gallery-nav prev" onclick="changeImage(-1)"><i class="fa-solid fa-chevron-left"></i></button>
                            <button class="gallery-nav next" onclick="changeImage(1)"><i class="fa-solid fa-chevron-right"></i></button>
                            <span class="gallery-counter" id="gallery-counter">1 / {{ $vehicule->images->count() }}</span>
                        @endif
                    @else
                        <span>🚗</span>
                    @endif
                </div>

                @if($vehicule->images->count() > 1)
                    <div class="gallery-thumbs">
                        @foreach($vehicule->images as $index => $image)
                            <div class="gallery-thumb {{ $index === 0 ? 'active' : '' }}" onclick="jumpToImage({{ $index }})" data-index="{{ $index }}">
                                <img src="{{ asset('storage/' . $image->path) }}" alt="Thumbnail">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Description --}}
            <div class="info-card">
                <h3>Description</h3>
                <p>{{ $vehicule->description }}</p>
            </div>

            {{-- Equipements --}}
            @if($vehicule->equipements && count($vehicule->equipements) > 0)
            <div class="info-card">
                <h3>Équipements &amp; Options</h3>
                <div class="equip-grid">
                    @foreach($vehicule->equipements as $equip)
                    <div class="equip-item">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ $equip }}
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Tech Sheet --}}
            <div class="tech-sheet">
                <h3>Fiche Technique</h3>
                @foreach([
                    ['Marque',        $marque->nom],
                    ['Modèle',        $vehicule->modele],
                    ['Année',         $vehicule->annee],
                    ['Carburant',     $vehicule->carburant],
                    ['Puissance',     $vehicule->puissance . ' ch'],
                    ['Couple',        $vehicule->couple . ' Nm'],
                    ['Transmission',  $vehicule->transmission],
                    ['Consommation',  $vehicule->consommation . ' L/100km'],
                    ['Nb de portes',  $vehicule->nb_portes],
                    ['Nb de places',  $vehicule->nb_places],
                    ['Volume coffre', $vehicule->volume_coffre . ' L'],
                    ['Couleur',       $vehicule->couleur],
                    ['Kilométrage',   number_format($vehicule->kilometrage, 0, ',', ' ') . ' km'],
                    ['Garantie',      $vehicule->garantie . ' ans'],
                ] as [$key, $val])
                <div class="tech-row">
                    <span class="tech-key">{{ $key }}</span>
                    <span class="tech-val">{{ $val }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- RIGHT: SIDEBAR --}}
        <div>
            <div class="sidebar-card">
                <span class="brand-badge">{{ $marque->nom }}</span>
                <h2>{{ $marque->nom }} {{ $vehicule->modele }}</h2>
                <div class="year-fuel">{{ $vehicule->annee }} · {{ $vehicule->carburant }}</div>

                <div class="price-label">Prix à partir de</div>
                <div class="price-big">{{ number_format($vehicule->prix, 0, ',', ' ') }} €</div>

                <button class="btn-devis" onclick="document.getElementById('devisModal').classList.add('open')">
                    <i class="fa-solid fa-file-invoice" style="margin-right:8px"></i>
                    Demander un devis PDF
                </button>
                <button class="btn-compare" id="btnCompare" onclick="addToComparator({{ $vehicule->id }})">
                    <i class="fa-regular fa-plus-square" style="margin-right:6px"></i>
                    Ajouter au comparateur
                </button>

                <div class="specs-section">
                    <h3>Caractéristiques clés</h3>
                    <div class="specs-grid">
                        <div class="spec-item">
                            <div class="spec-label"><i class="fa-solid fa-bolt" style="color:var(--blue)"></i> Puissance</div>
                            <div class="spec-value">{{ $vehicule->puissance }} ch</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label"><i class="fa-solid fa-gas-pump" style="color:var(--gray-400)"></i> Carburant</div>
                            <div class="spec-value">{{ $vehicule->carburant }}</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label"><i class="fa-solid fa-gauge" style="color:var(--orange)"></i> Consommation</div>
                            <div class="spec-value">{{ $vehicule->consommation }} L/100km</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label"><i class="fa-regular fa-calendar" style="color:var(--gray-400)"></i> Année</div>
                            <div class="spec-value">{{ $vehicule->annee }}</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label"><i class="fa-solid fa-users" style="color:var(--gray-400)"></i> Places</div>
                            <div class="spec-value">{{ $vehicule->nb_places }}</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label"><i class="fa-solid fa-box" style="color:var(--gray-400)"></i> Coffre</div>
                            <div class="spec-value">{{ $vehicule->volume_coffre }} L</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- DEVIS MODAL --}}
<div id="devisModal" class="modal-overlay" onclick="if(event.target===this)closeDevisModal()">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <h3><i class="fa-solid fa-file-invoice" style="margin-right:8px"></i>Demander un devis</h3>
                <p>Recevez votre devis PDF instantanément</p>
            </div>
            <button class="modal-close" onclick="closeDevisModal()">✕</button>
        </div>
        <div class="modal-body">
            <div class="modal-car-info">
                <i class="fa-solid fa-car"></i>
                <div>
                    <strong>{{ $marque->nom }} {{ $vehicule->modele }}</strong> · {{ $vehicule->annee }}<br>
                    <span style="color:#4b5563">{{ number_format($vehicule->prix, 0, ',', ' ') }} €</span>
                </div>
            </div>

            <form method="POST" action="{{ route('voitures.devis', [$marque->slug, $vehicule->slug]) }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Prénom *</label>
                        <input type="text" name="prenom" class="form-input" placeholder="Votre prénom" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nom *</label>
                        <input type="text" name="nom" class="form-input" placeholder="Votre nom" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Adresse e-mail *</label>
                    <input type="email" name="email" class="form-input" placeholder="votre@email.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Téléphone *</label>
                    <input type="tel" name="telephone" class="form-input" placeholder="+216 XX XXX XXX" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Message (optionnel)</label>
                    <textarea name="message" class="form-input" placeholder="Précisions, questions, délai souhaité..."></textarea>
                </div>
                <button type="submit" class="btn-submit-devis">
                    <i class="fa-solid fa-download"></i>
                    Générer et télécharger le PDF
                </button>
            </form>
        </div>
    </div>
</div>

{{-- COMPARE TOAST --}}
<div id="compareToast" class="compare-toast">
    <span id="toastMsg"></span>
    <a id="toastLink" href="#" style="display:none">
        <i class="fa-solid fa-code-compare" style="margin-right:4px"></i> Voir le comparateur
    </a>
    <button class="toast-dismiss" onclick="document.getElementById('compareToast').classList.remove('show')">✕</button>
</div>

@endsection

@isset($vehicule->images) @if($vehicule->images->count() > 1)
@push('scripts')
<script>
    const images = @json($vehicule->images->map(fn($i) => asset('storage/' . $i->path)));
    let currentIndex = 0;

    function changeImage(delta) {
        currentIndex = (currentIndex + delta + images.length) % images.length;
        updateGallery();
    }

    function jumpToImage(index) {
        currentIndex = index;
        updateGallery();
    }

    function updateGallery() {
        const mainImg = document.getElementById('main-img');
        const counter = document.getElementById('gallery-counter');
        const thumbs = document.querySelectorAll('.gallery-thumb');

        mainImg.style.opacity = '0';
        setTimeout(() => {
            mainImg.src = images[currentIndex];
            mainImg.style.opacity = '1';
        }, 150);

        counter.innerText = `${currentIndex + 1} / ${images.length}`;

        thumbs.forEach((thumb, i) => {
            if (i === currentIndex) thumb.classList.add('active');
            else thumb.classList.remove('active');
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') changeImage(-1);
        if (e.key === 'ArrowRight') changeImage(1);
    });
</script>
@endpush
@endif @endisset

@push('scripts')
<script>
    function closeDevisModal() {
        document.getElementById('devisModal').classList.remove('open');
    }
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeDevisModal();
    });
</script>
@endpush

@push('scripts')
<script>
    const VEHICULE_ID = {{ $vehicule->id }};
    const COMPARE_URL = '{{ route("comparer") }}';
    let toastTimer;

    function addToComparator(id) {
        let ids = JSON.parse(localStorage.getItem('comparateur') || '[]');

        if (ids.includes(id)) {
            showToast('⚠️ Cette voiture est déjà dans le comparateur.', true);
            return;
        }
        if (ids.length >= 4) {
            showToast('⚠️ Le comparateur est limité à 4 véhicules.', true);
            return;
        }

        ids.push(id);
        localStorage.setItem('comparateur', JSON.stringify(ids));

        const btn = document.getElementById('btnCompare');
        btn.innerHTML = '<i class="fa-solid fa-check" style="margin-right:6px"></i> Ajouté au comparateur';
        btn.style.color = '#059669';
        btn.disabled = true;

        const params = ids.map(i => `ids[]=${i}`).join('&');
        const url = `${COMPARE_URL}?${params}`;
        showToast(`✓ Voiture ajoutée ! (${ids.length}/4)`, false, url);
    }

    function showToast(message, isWarning, compareUrl = null) {
        clearTimeout(toastTimer);
        const toast = document.getElementById('compareToast');
        const msg   = document.getElementById('toastMsg');
        const link  = document.getElementById('toastLink');

        msg.textContent = message;
        toast.style.background = isWarning ? '#92400e' : '#111827';
        link.style.display = (compareUrl && !isWarning) ? 'inline-block' : 'none';
        if (compareUrl) link.href = compareUrl;

        toast.classList.add('show');
        toastTimer = setTimeout(() => toast.classList.remove('show'), 4500);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const ids = JSON.parse(localStorage.getItem('comparateur') || '[]');
        if (ids.includes(VEHICULE_ID)) {
            const btn = document.getElementById('btnCompare');
            btn.innerHTML = '<i class="fa-solid fa-check" style="margin-right:6px"></i> Déjà dans le comparateur';
            btn.style.color = '#059669';
            btn.disabled = true;
        }
    });
</script>
@endpush
