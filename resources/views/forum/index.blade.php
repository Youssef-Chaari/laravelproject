@extends('layouts.app')

@section('title', 'Forum – AutoMoto')

@push('styles')
<style>
    .forum-body { max-width: 900px; margin: 0 auto; padding: 36px 24px 64px; }

    /* ── HEADER ── */
    .forum-header {
        display: flex; justify-content: space-between; align-items: flex-start;
        margin-bottom: 28px;
    }
    .forum-header h1 { font-size: 26px; font-weight: 700; }
    .forum-header p { font-size: 15px; color: var(--gray-500); margin-top: 4px; }
    .btn-new {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 20px;
        background: var(--blue); color: #fff;
        border: none; border-radius: var(--radius);
        font-size: 15px; font-weight: 600;
        cursor: pointer; text-decoration: none;
        transition: background .15s; white-space: nowrap;
    }
    .btn-new:hover { background: var(--blue-dark); }

    /* ── FILTERS ── */
    .forum-filters {
        display: flex; gap: 8px; margin-bottom: 24px;
    }
    .filter-pill {
        padding: 8px 18px;
        border-radius: 24px;
        font-size: 14px; font-weight: 500;
        text-decoration: none; color: var(--gray-600);
        border: 1px solid var(--gray-200);
        background: #fff; cursor: pointer;
        transition: all .15s;
    }
    .filter-pill:hover { border-color: var(--blue); color: var(--blue); }
    .filter-pill.active {
        background: var(--gray-900); color: #fff;
        border-color: var(--gray-900);
    }

    /* ── TOPICS ── */
    .topic-list { display: flex; flex-direction: column; gap: 0; }
    .topic-item {
        background: #fff;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius);
        margin-bottom: 12px;
        transition: box-shadow .15s;
    }
    .topic-item:hover { box-shadow: var(--shadow-md); }
    .topic-main { padding: 20px 24px; }
    .topic-header {
        display: flex; justify-content: space-between; align-items: flex-start;
        gap: 16px;
    }
    .topic-left { display: flex; gap: 14px; align-items: flex-start; flex: 1; }
    .topic-avatar {
        width: 40px; height: 40px; border-radius: 50%;
        background: var(--blue-light); color: var(--blue);
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700; flex-shrink: 0;
    }
    .topic-content { flex: 1; }
    .topic-title {
        font-size: 16px; font-weight: 700; color: var(--gray-900);
        margin-bottom: 4px; text-decoration: none;
    }
    .topic-title:hover { color: var(--blue); }
    .topic-meta {
        font-size: 13px; color: var(--gray-400);
        display: flex; align-items: center; gap: 6px;
    }
    .topic-meta strong { color: var(--gray-600); }
    .topic-excerpt {
        font-size: 14px; color: var(--gray-500);
        margin-top: 8px; line-height: 1.6;
    }
    .topic-footer {
        display: flex; align-items: center; gap: 20px;
        margin-top: 12px;
    }
    .topic-stat {
        display: flex; align-items: center; gap: 5px;
        font-size: 13px; color: var(--gray-400);
    }

    /* ── BADGE COLORS ── */
    .badge-avis    { background: #EDE9FE; color: #5B21B6; }
    .badge-conseils { background: #D1FAE5; color: #065F46; }
    .badge-actualites { background: var(--blue-light); color: var(--blue); }
    .badge-questions { background: #FEF3C7; color: #92400E; }

    /* ── COMMENTS (expanded topic) ── */
    .topic-comments { border-top: 1px solid var(--gray-100); }
    .comment-item {
        padding: 14px 24px; border-bottom: 1px solid var(--gray-100);
        display: grid; grid-template-columns: 28px 1fr auto;
        gap: 12px; align-items: start;
    }
    .comment-item:last-child { border-bottom: none; }
    .comment-avatar {
        width: 28px; height: 28px; border-radius: 50%;
        background: var(--gray-200); display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 600; color: var(--gray-500);
    }
    .comment-body { }
    .comment-author { font-size: 13px; font-weight: 600; margin-bottom: 2px; }
    .comment-text { font-size: 13px; color: var(--gray-600); }
    .comment-time { font-size: 12px; color: var(--gray-400); }
    .add-comment {
        padding: 12px 24px;
        display: flex; align-items: center; gap: 12px;
    }
    .add-comment input {
        flex: 1; border: none; outline: none;
        font-size: 14px; font-family: inherit;
        color: var(--gray-500);
    }
    .add-comment input::placeholder { color: var(--gray-400); }

    /* ── MODAL ── */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,.4); z-index: 200;
        align-items: center; justify-content: center;
    }
    .modal-overlay.open { display: flex; }
    .modal {
        background: #fff; border-radius: 16px;
        padding: 32px; width: 540px; max-width: 90vw;
        position: relative;
    }
    .modal-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 24px;
    }
    .modal h2 { font-size: 20px; font-weight: 700; }
    .modal-close {
        width: 32px; height: 32px; border: none; background: none;
        border-radius: 8px; cursor: pointer; font-size: 18px;
        color: var(--gray-400); transition: all .15s;
        display: flex; align-items: center; justify-content: center;
    }
    .modal-close:hover { background: var(--gray-100); color: var(--gray-700); }
    .modal .form-group { margin-bottom: 18px; }
    .modal .form-label {
        font-size: 14px; font-weight: 500; color: var(--gray-700);
        margin-bottom: 7px; display: block;
    }
    .modal .form-input, .modal .form-select, .modal .form-textarea {
        width: 100%; padding: 11px 14px;
        border: 1px solid var(--gray-200); border-radius: var(--radius-sm);
        font-size: 14px; font-family: inherit;
        outline: none; transition: border-color .15s;
    }
    .modal .form-input:focus, .modal .form-select:focus, .modal .form-textarea:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(37,99,235,.1);
    }
    .modal .form-select { appearance: none; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px;
    }
    .modal .form-textarea { min-height: 120px; resize: vertical; }
    .modal-footer {
        display: flex; justify-content: flex-end; gap: 10px; margin-top: 4px;
    }
    .btn-cancel {
        padding: 10px 20px; border: none; background: none;
        font-size: 15px; font-weight: 500; color: var(--gray-500);
        cursor: pointer; border-radius: var(--radius);
        transition: background .15s;
    }
    .btn-cancel:hover { background: var(--gray-100); }
    .btn-publish {
        display: flex; align-items: center; gap: 6px;
        padding: 10px 22px;
        background: var(--blue); color: #fff;
        border: none; border-radius: var(--radius);
        font-size: 15px; font-weight: 600;
        cursor: pointer; transition: background .15s;
    }
    .btn-publish:hover { background: var(--blue-dark); }
</style>
@endpush

@section('content')

<div class="forum-body">
    {{-- HEADER --}}
    <div class="forum-header">
        <div>
            <h1>Forum AutoMoto</h1>
            <p>Échangez avec la communauté</p>
        </div>
        <button class="btn-new" onclick="document.getElementById('newTopicModal').classList.add('open')">
            <i class="fa-solid fa-plus"></i>
            Nouveau sujet
        </button>
    </div>

    {{-- FILTERS --}}
    <div class="forum-filters">
        @foreach(['Tous', 'Actualités', 'Conseils', 'Avis', 'Questions'] as $filter)
        <a href="{{ route('forum.index', ['categorie' => $filter === 'Tous' ? '' : strtolower($filter)]) }}"
           class="filter-pill {{ (request('categorie', '') === strtolower($filter) || ($filter === 'Tous' && !request('categorie'))) ? 'active' : '' }}">
            {{ $filter }}
        </a>
        @endforeach
    </div>

    {{-- TOPICS --}}
    <div class="topic-list">
        @foreach($sujets as $sujet)
        @php
            $badgeMap = ['avis'=>'badge-avis','conseils'=>'badge-conseils','actualites'=>'badge-actualites','questions'=>'badge-questions'];
            $badgeClass = $badgeMap[strtolower($sujet->categorie)] ?? 'badge-gray';
        @endphp
        <div class="topic-item">
            <div class="topic-main">
                <div class="topic-header">
                    <div class="topic-left">
                        <div class="topic-avatar">{{ strtoupper(substr($sujet->auteur_pseudo, 0, 2)) }}</div>
                        <div class="topic-content">
                            <a href="{{ route('forum.show', $sujet->id) }}" class="topic-title">
                                {{ $sujet->title }}
                            </a>
                            <div class="topic-meta">
                                <strong>{{ $sujet->auteur_pseudo }}</strong>
                                <span>•</span>
                                <i class="fa-regular fa-clock" style="font-size:11px"></i>
                                {{ $sujet->date_relative }}
                            </div>
                            <p class="topic-excerpt">{{ Str::limit($sujet->content, 100) }}</p>
                        </div>
                    </div>
                    <span class="badge {{ $badgeClass }}">{{ ucfirst($sujet->categorie) }}</span>
                </div>
                <div class="topic-footer">
                    <span class="topic-stat">
                        <i class="fa-regular fa-comment"></i>
                        {{ $sujet->reponses_count }} réponses
                    </span>
                    <div class="topic-stat">
                        <i class="fa-regular fa-heart"></i>
                        <span>{{ $sujet->likes_count }} likes</span>
                    </div>
                    @if(auth()->id() === $sujet->user_id || auth()->user()->role === 'admin')
                        <form method="POST" action="{{ route('forum.destroy', $sujet->id) }}" onsubmit="return confirm('Supprimer ce sujet ?')" style="margin-left: auto;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete" style="background: none; border: none; color: var(--gray-400); cursor: pointer; font-size: 14px; transition: color .15s;">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Expanded comments (first topic) --}}
            @if($loop->first && $sujet->commentaires->isNotEmpty())
            <div class="topic-comments">
                @foreach($sujet->commentaires->take(3) as $comment)
                <div class="comment-item">
                    <div class="comment-avatar">{{ strtoupper(substr($comment->auteur, 0, 1)) }}</div>
                    <div class="comment-body">
                        <div class="comment-author">{{ $comment->auteur }}</div>
                        <div class="comment-text">{{ $comment->contenu }}</div>
                    </div>
                    <span class="comment-time">{{ $comment->date_relative }}</span>
                </div>
                @endforeach
                <div class="add-comment">
                    <div class="comment-avatar" style="background:var(--gray-100)"></div>
                    <input type="text" placeholder="Ajouter un commentaire...">
                    <i class="fa-solid fa-paper-plane" style="color:var(--blue);cursor:pointer"></i>
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>

{{-- MODAL: Nouveau sujet --}}
<div class="modal-overlay" id="newTopicModal" onclick="if(event.target===this)this.classList.remove('open')">
    <div class="modal">
        <div class="modal-header">
            <h2>Nouveau sujet</h2>
            <button class="modal-close" onclick="document.getElementById('newTopicModal').classList.remove('open')">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('forum.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Titre du sujet *</label>
                <input type="text" name="titre" class="form-input" placeholder="Ex: Meilleure voiture pour famille de 4 ?" required>
            </div>
            <div class="form-group">
                <label class="form-label">Catégorie *</label>
                <select name="categorie" class="form-select" required>
                    <option value="questions">Questions</option>
                    <option value="avis">Avis</option>
                    <option value="conseils">Conseils</option>
                    <option value="actualites">Actualités</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Contenu *</label>
                <textarea name="contenu" class="form-textarea" placeholder="Décrivez votre sujet en détail..." required></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="document.getElementById('newTopicModal').classList.remove('open')">Annuler</button>
                <button type="submit" class="btn-publish">
                    <i class="fa-solid fa-paper-plane" style="font-size:13px"></i>
                    Publier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
