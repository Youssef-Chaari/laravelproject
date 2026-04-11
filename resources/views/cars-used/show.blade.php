@extends('layouts.app')

@section('title', ($annonce->marque->nom ?? 'Marque') . ' ' . $annonce->modele . ' – Occasion')

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
        height: 380px;
        display: flex; align-items: center; justify-content: center;
        font-size: 120px;
        background: linear-gradient(135deg, #3B82F6, #1E3A8A);
    }
    .gallery-badge {
        position: absolute; top: 16px; left: 16px;
        background: rgba(0,0,0,.6); color: #fff;
        font-size: 12px; font-weight: 700;
        padding: 4px 12px; border-radius: 20px;
        text-transform: uppercase; letter-spacing: 0.5px;
        z-index: 10;
    }

    /* ── GALLERY NAVIGATION ── */
    .gallery-nav {
        position: absolute; top: 0; bottom: 0; width: 60px;
        display: flex; align-items: center; justify-content: center;
        background: transparent; border: none; color: #fff;
        font-size: 24px; cursor: pointer; transition: all .2s;
        z-index: 5;
    }
    .gallery-nav.prev { left: 0; background: linear-gradient(to right, rgba(0,0,0,0.3), transparent); }
    .gallery-nav.next { right: 0; background: linear-gradient(to left, rgba(0,0,0,0.3), transparent); }
    .gallery-nav:hover { background: rgba(0,0,0,0.4); font-size: 28px; }

    /* ── THUMBNAILS ── */
    .gallery-thumbnails {
        display: flex; gap: 10px; margin-top: 12px;
        overflow-x: auto; padding-bottom: 5px;
    }
    .gallery-thumbnails::-webkit-scrollbar { height: 4px; }
    .gallery-thumbnails::-webkit-scrollbar-thumb { background: var(--gray-200); border-radius: 2px; }
    
    .thumb-item {
        width: 80px; height: 60px; border-radius: 8px;
        overflow: hidden; cursor: pointer; flex-shrink: 0;
        border: 2px solid transparent; transition: all .2s;
        background: var(--gray-100);
    }
    .thumb-item img { width: 100%; height: 100%; object-fit: cover; }
    .thumb-item.active { border-color: var(--blue); box-shadow: 0 0 0 2px rgba(37,99,235,0.1); }
    .thumb-item:hover { transform: translateY(-2px); }

    /* ── INFO CARDS ── */
    .info-card {
        background: #fff; border-radius: var(--radius);
        border: 1px solid var(--gray-200);
        padding: 24px; margin-top: 20px;
    }
    .info-card h3 { font-size: 16px; font-weight: 700; margin-bottom: 14px; color: var(--gray-900); }
    .info-card p { font-size: 14px; color: var(--gray-600); line-height: 1.7; }

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
        color: var(--gray-900);
    }
    .sidebar-card .year-km {
        font-size: 14px; color: var(--gray-500); margin-bottom: 20px;
    }
    .price-label { font-size: 13px; color: var(--gray-500); margin-bottom: 4px; }
    .price-big {
        font-size: 32px; font-weight: 700; color: var(--orange);
        margin-bottom: 24px;
    }

    .seller-box {
        background: var(--gray-50); border-radius: 12px;
        padding: 16px; margin-bottom: 20px;
        display: flex; align-items: center; gap: 12px;
    }
    .seller-avatar {
        width: 44px; height: 44px; border-radius: 50%;
        background: var(--blue); color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; font-weight: 700;
    }
    .seller-info .name { font-size: 14px; font-weight: 700; color: var(--gray-900); }
    .seller-info .date { font-size: 12px; color: var(--gray-400); }

    .btn-contact {
        width: 100%; padding: 14px;
        background: var(--blue); color: #fff;
        border: none; border-radius: var(--radius);
        font-size: 15px; font-weight: 600;
        cursor: pointer; transition: background .15s;
        text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-contact:hover { background: var(--blue-dark); }

    .admin-actions {
        margin-top: 20px; padding-top: 20px;
        border-top: 1px solid var(--gray-100);
        display: flex; gap: 10px;
    }

    @media (max-width: 960px) {
        .detail-layout { grid-template-columns: 1fr; }
        .sidebar-card { position: static; }
    }
</style>
@endpush

@section('content')

<div class="breadcrumb">
    <a href="{{ route('occasions.index') }}">Occasions</a>
    <span class="sep"><i class="fa-solid fa-chevron-right" style="font-size:10px"></i></span>
    <span class="current">{{ $annonce->marque->nom ?? 'Véhicule' }}</span>
</div>

<div class="page-body">
    <a href="{{ route('occasions.index') }}" class="back-link">
        <i class="fa-solid fa-arrow-left" style="font-size:13px"></i>
        Retour aux annonces
    </a>

    <div class="detail-layout">

        {{-- LEFT: IMAGE + INFO --}}
        <div>
            <div class="gallery-wrapper">
                <div class="gallery-main" id="main-viewer">
                    <span class="gallery-badge">Occasion</span>
                    
                    @if($annonce->images->isNotEmpty())
                        <button class="gallery-nav prev" onclick="changeImage(-1)"><i class="fa-solid fa-chevron-left"></i></button>
                        <button class="gallery-nav next" onclick="changeImage(1)"><i class="fa-solid fa-chevron-right"></i></button>
                        
                        <img id="main-img" src="{{ asset('storage/' . $annonce->images->first()->path) }}" alt="{{ $annonce->titre }}" style="width:100%; height:100%; object-fit:cover; transition: opacity 0.2s;">
                    @else
                        <div style="display:flex; align-items:center; justify-content:center; width:100%; height:100%; font-size:120px; background:linear-gradient(135deg, #3B82F6, #1E3A8A)">
                            <span>🚙</span>
                        </div>
                    @endif
                </div>

                @if($annonce->images->count() > 1)
                    <div class="gallery-thumbnails">
                        @foreach($annonce->images as $index => $image)
                            <div class="thumb-item {{ $index === 0 ? 'active' : '' }}" onclick="jumpToImage({{ $index }})" data-index="{{ $index }}">
                                <img src="{{ asset('storage/' . $image->path) }}" alt="Thumbnail">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Description --}}
            <div class="info-card">
                <h3>Description du vendeur</h3>
                <p>{{ $annonce->description ?: 'Aucune description fournie par le vendeur.' }}</p>
            </div>

            {{-- Tech Sheet --}}
            <div class="tech-sheet">
                <h3>Fiche Technique</h3>
                @foreach([
                    ['Marque',        $annonce->marque->nom ?? 'N/A'],
                    ['Modèle',        $annonce->modele],
                    ['Année',         $annonce->annee],
                    ['Kilométrage',   number_format($annonce->kilometrage, 0, ',', ' ') . ' km'],
                    ['Carburant',     ucfirst($annonce->carburant)],
                    ['Transmission',  ucfirst($annonce->transmission)],
                    ['Puissance',     $annonce->puissance . ' ch'],
                    ['Ville',         $annonce->ville ?? 'Non renseignée'],
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
                <span class="brand-badge">{{ $annonce->marque->nom ?? 'Particulier' }}</span>
                <h2>{{ $annonce->titre }}</h2>
                <div class="year-km">{{ $annonce->annee }} · {{ number_format($annonce->kilometrage, 0, ',', ' ') }} km</div>

                <div class="price-label">Prix de vente</div>
                <div class="price-big">{{ number_format($annonce->prix, 0, ',', ' ') }} €</div>

                <div class="seller-box">
                    <div class="seller-avatar">{{ strtoupper(substr($annonce->user->name ?? 'A', 0, 1)) }}</div>
                    <div class="seller-info">
                        <div class="name">{{ $annonce->user->name ?? 'Anonyme' }}</div>
                        <div class="date">Publié {{ $annonce->created_at->diffForHumans() }}</div>
                    </div>
                </div>

                <a href="mailto:{{ $annonce->user->email ?? '' }}?subject=Annonce AutoMoto: {{ $annonce->titre }}" class="btn-contact">
                    <i class="fa-solid fa-envelope"></i>
                    Contacter le vendeur
                </a>

                @auth
                    @if(auth()->id() === $annonce->user_id || auth()->user()->isAdmin())
                        <div class="admin-actions">
                            <a href="#" class="btn btn-outline" style="flex:1; justify-content:center">Modifier</a>
                            <form method="POST" action="{{ route('occasions.destroy', $annonce->id) }}" onsubmit="return confirm('Désirez-vous vraiment supprimer cette annonce ?')" style="flex:1">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="width:100%; justify-content:center">Supprimer</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    const images = @json($annonce->images->map(fn($i) => asset('storage/' . $i->path)));
    let currentIndex = 0;

    function changeImage(delta) {
        if (!images.length) return;
        currentIndex = (currentIndex + delta + images.length) % images.length;
        updateGallery();
    }

    function jumpToImage(index) {
        currentIndex = index;
        updateGallery();
    }

    function updateGallery() {
        const mainImg = document.getElementById('main-img');
        const thumbs = document.querySelectorAll('.thumb-item');

        // Fade out
        mainImg.style.opacity = '0';

        setTimeout(() => {
            mainImg.src = images[currentIndex];
            // Fade in
            mainImg.style.opacity = '1';
        }, 150);

        // Update active thumb
        thumbs.forEach((thumb, i) => {
            if (i === currentIndex) {
                thumb.classList.add('active');
                thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            } else {
                thumb.classList.remove('active');
            }
        });
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') changeImage(-1);
        if (e.key === 'ArrowRight') changeImage(1);
    });
</script>
@endpush

