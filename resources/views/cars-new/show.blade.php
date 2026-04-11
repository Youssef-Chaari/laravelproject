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

                <button class="btn-devis">Demander un devis</button>
                <button class="btn-compare">
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
