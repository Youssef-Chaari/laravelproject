@extends('layouts.app')
@section('title', $topic->title)

@push('styles')
<style>
    .forum-container { max-width: 900px; margin: 0 auto; padding: 36px 24px 64px; }
    
    .back-nav { margin-bottom: 24px; }
    .btn-back {
        display: inline-flex; align-items: center; gap: 8px;
        color: var(--gray-500); text-decoration: none;
        font-size: 14px; font-weight: 500; transition: color .15s;
    }
    .btn-back:hover { color: var(--blue); }

    /* ── TOPIC DETAIL ── */
    .topic-card {
        background: #fff; border: 1px solid var(--gray-200);
        border-radius: 20px; padding: 40px; margin-bottom: 32px;
        box-shadow: 0 4px 20px rgba(0,0,0,.03);
    }
    .topic-card-header { display: flex; align-items: center; gap: 14px; margin-bottom: 24px; }
    .author-avatar {
        width: 48px; height: 48px; border-radius: 50%;
        background: var(--blue-light); color: var(--blue);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; font-weight: 700;
    }
    .author-info h3 { font-size: 15px; font-weight: 700; color: var(--gray-900); }
    .author-info p { font-size: 12px; color: var(--gray-400); margin-top: 2px; }

    .topic-card h1 {
        font-size: 28px; font-weight: 800; color: var(--gray-900);
        line-height: 1.3; margin-bottom: 20px;
    }
    .topic-card-content {
        font-size: 16px; color: var(--gray-600); line-height: 1.7;
        white-space: pre-line;
    }

    /* ── COMMENTS ── */
    .comments-header {
        display: flex; align-items: center; gap: 12px; margin-bottom: 20px;
    }
    .comments-header h2 { font-size: 18px; font-weight: 700; }
    .comment-count {
        background: var(--gray-100); color: var(--gray-600);
        font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 12px;
    }

    .comment-list { display: flex; flex-direction: column; gap: 16px; margin-bottom: 40px; }
    .comment-card {
        background: #fff; border: 1px solid var(--gray-200);
        border-radius: 16px; padding: 24px; display: flex; gap: 16px;
    }
    .comment-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: var(--gray-100); color: var(--gray-500);
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700; flex-shrink: 0;
    }
    .comment-main { flex: 1; }
    .comment-top {
        display: flex; justify-content: space-between; align-items: flex-start;
        margin-bottom: 8px;
    }
    .comment-author { font-size: 14px; font-weight: 700; color: var(--gray-800); }
    .comment-date { font-size: 12px; color: var(--gray-400); margin-top: 2px; }
    .comment-content { font-size: 14px; color: var(--gray-600); line-height: 1.6; }

    .btn-delete {
        background: none; border: none; color: var(--gray-400);
        cursor: pointer; font-size: 14px; transition: color .15s;
    }
    .btn-delete:hover { color: var(--red); }

    /* ── REPLY FORM ── */
    .reply-card {
        background: #fff; border: 1px solid var(--gray-200);
        border-radius: 20px; padding: 32px;
    }
    .reply-card h3 { font-size: 17px; font-weight: 700; margin-bottom: 20px; }
    .reply-textarea {
        width: 100%; min-height: 120px; padding: 16px;
        background: var(--gray-50); border: 1px solid var(--gray-200);
        border-radius: 12px; font-family: inherit; font-size: 14px;
        margin-bottom: 16px; outline: none; transition: all .15s;
    }
    .reply-textarea:focus {
        border-color: var(--blue); background: #fff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.05);
    }
    .btn-submit {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 12px 28px; background: var(--blue); color: #fff;
        border: none; border-radius: 12px; font-size: 15px; font-weight: 600;
        cursor: pointer; transition: background .15s;
    }
    .btn-submit:hover { background: var(--blue-dark); }

    .guest-cta {
        background: var(--blue-light); border: 1px solid rgba(37, 99, 235, 0.1);
        border-radius: 20px; padding: 40px; text-align: center;
    }
    .guest-cta h3 { font-size: 18px; font-weight: 700; color: var(--gray-900); margin-bottom: 8px; }
    .guest-cta p { color: var(--gray-500); margin-bottom: 24px; }
    .btn-auth-group { display: flex; justify-content: center; gap: 12px; }
    .btn-login {
        padding: 10px 24px; background: var(--blue); color: #fff;
        border-radius: 10px; font-weight: 600; text-decoration: none;
    }
    .btn-register {
        padding: 10px 24px; background: #fff; color: var(--gray-700);
        border: 1px solid var(--gray-200); border-radius: 10px;
        font-weight: 600; text-decoration: none;
    }
</style>
@endpush

@section('content')
<div class="forum-container">
    {{-- BACK NAV --}}
    <div class="back-nav">
        <a href="{{ route('forum.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i>
            Retour au forum
        </a>
    </div>

    <x-flash-message />

    {{-- TOPIC DETAIL --}}
    <div class="topic-card">
        <div class="topic-card-header">
            <div class="author-avatar">
                {{ strtoupper(substr($topic->user->name, 0, 1)) }}
            </div>
            <div class="author-info">
                <h3>{{ $topic->user->name }}</h3>
                <p>Publié le {{ $topic->created_at->format('d/m/Y à H:i') }}</p>
            </div>
            
            @auth
                @if(auth()->id() === $topic->user_id || auth()->user()->role === 'admin')
                    <div style="margin-left: auto;">
                        <form method="POST" action="{{ route('forum.destroy', $topic) }}" onsubmit="return confirm('Supprimer ce sujet et tous ses commentaires ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete" style="color: var(--gray-400); font-size: 18px; background: none; border: none; cursor: pointer; transition: color .15s;">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
        
        <h1>{{ $topic->title }}</h1>
        
        <div class="topic-card-content">
            {{ $topic->content }}
        </div>

        <div style="margin-top: 24px; display: flex; align-items: center; gap: 16px; border-top: 1px solid var(--gray-100); padding-top: 20px;">
            <form method="POST" action="{{ route('forum.like', $topic) }}">
                @csrf
                <button type="submit" class="btn-like {{ $topic->isLikedByUser(auth()->id()) ? 'active' : '' }}" style="background: none; border: 1px solid var(--gray-200); padding: 8px 16px; border-radius: 10px; cursor: pointer; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: all .15s; color: {{ $topic->isLikedByUser(auth()->id()) ? 'var(--blue)' : 'var(--gray-500)' }}; border-color: {{ $topic->isLikedByUser(auth()->id()) ? 'var(--blue)' : 'var(--gray-200)' }};">
                    <i class="{{ $topic->isLikedByUser(auth()->id()) ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                    <span>{{ $topic->likes()->count() }}</span>
                </button>
            </form>
        </div>
    </div>

    {{-- COMMENTS SECTION --}}
    <div class="comments-header">
        <h2>Réponses</h2>
        <span class="comment-count">{{ $comments->total() }}</span>
    </div>

    <div class="comment-list">
        @forelse($comments as $comment)
            <div class="comment-card" id="comment-{{ $comment->id }}">
                <div class="comment-avatar">
                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                </div>
                <div class="comment-main">
                    <div class="comment-top">
                        <div class="comment-author-info">
                            <h4 class="comment-author">{{ $comment->user->name }}</h4>
                            <p class="comment-date">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                        @auth
                            @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                                <form method="POST" action="{{ route('forum.comment.destroy', $comment) }}" onsubmit="return confirm('Supprimer ce commentaire ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-delete" title="Supprimer">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    <div class="comment-content">
                        {{ $comment->content }}
                    </div>

                    <div style="margin-top: 12px;">
                        <form method="POST" action="{{ route('forum.comment.like', $comment) }}">
                            @csrf
                            <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 6px; color: {{ $comment->isLikedByUser(auth()->id()) ? 'var(--blue)' : 'var(--gray-400)' }}; transition: color .15s;">
                                <i class="{{ $comment->isLikedByUser(auth()->id()) ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                <span>{{ $comment->likes()->count() }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 48px; background: #fff; border: 1px dashed var(--gray-200); border-radius: 16px; color: var(--gray-400);">
                Aucune réponse pour le moment. Soyez le premier à répondre !
            </div>
        @endforelse
    </div>

    @if($comments->hasPages())
        <div style="margin-bottom: 40px;">
            {{ $comments->links() }}
        </div>
    @endif

    {{-- REPLY FORM --}}
    @auth
        <div class="reply-card">
            <h3>Ajouter une réponse</h3>
            <form method="POST" action="{{ route('forum.comment.store', $topic) }}">
                @csrf
                <textarea name="content" class="reply-textarea" placeholder="Rédigez votre réponse ici..." required>{{ old('content') }}</textarea>
                @error('content') <p style="color:var(--red); font-size:13px; margin-bottom:12px;">{{ $message }}</p> @enderror
                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn-submit">
                        <i class="fa-regular fa-paper-plane"></i>
                        Publier la réponse
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="guest-cta">
            <h3>Rejoignez la discussion</h3>
            <p>Connectez-vous à votre compte pour répondre à ce sujet et échanger avec la communauté.</p>
            <div class="btn-auth-group">
                <a href="{{ route('login') }}" class="btn-login">Se connecter</a>
                <a href="{{ route('register') }}" class="btn-register">Créer un compte</a>
            </div>
        </div>
    @endauth
</div>
@endsection
