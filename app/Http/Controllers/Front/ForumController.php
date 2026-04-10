<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ForumTopic;
use App\Models\ForumComment;
use App\Models\Like;

class ForumController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = ForumTopic::with('user')->withCount(['comments', 'likes']);

        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        $sujets = $query->latest()->paginate(15);

        // Attach commentaires relationship for the expanded first topic
        $sujets->getCollection()->transform(function ($sujet) {
            $sujet->commentaires = ForumComment::where('topic_id', $sujet->id)
                ->with('user')->oldest()->get()
                ->map(function ($c) {
                    $c->auteur        = $c->user?->name ?? 'Anonyme';
                    $c->date_relative = $c->created_at->diffForHumans();
                    return $c;
                });

            $sujet->auteur_pseudo    = $sujet->user?->name ?? 'Anonyme';
            $sujet->date_relative    = $sujet->created_at->diffForHumans();
            $sujet->reponses_count   = $sujet->comments_count;
            $sujet->likes            = $sujet->likes_count;
            $sujet->categorie        = $sujet->categorie ?? 'questions';
            return $sujet;
        });

        return view('forum.index', compact('sujets'));
    }

    public function show(ForumTopic $topic)
    {
        $topic->load('user');
        $comments = ForumComment::where('topic_id', $topic->id)
            ->with('user')->oldest()->paginate(20);
        return view('forum.show', compact('topic', 'comments'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'titre'     => 'required|string|max:255',
            'categorie' => 'required|in:questions,avis,conseils,actualites',
            'contenu'   => 'required|string',
        ]);

        $topic = ForumTopic::create([
            'user_id'   => auth()->id(),
            'title'     => $request->titre,
            'content'   => $request->contenu,
            'categorie' => $request->categorie,
        ]);

        return redirect()->route('forum.index')->with('success', 'Sujet créé !');
    }

    public function destroy(ForumTopic $topic)
    {
        if (auth()->id() !== $topic->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $topic->delete();

        return redirect()->route('forum.index')->with('success', 'Sujet supprimé.');
    }

    public function storeComment(\Illuminate\Http\Request $request, ForumTopic $topic)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        ForumComment::create([
            'topic_id' => $topic->id,
            'user_id'  => auth()->id(),
            'content'  => $request->content,
        ]);

        return redirect()->route('forum.show', $topic)->with('success', 'Réponse publiée !');
    }

    public function destroyComment(ForumComment $comment)
    {
        if (auth()->id() !== $comment->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $topic = $comment->topic;
        $comment->delete();

        return redirect()->route('forum.show', $topic)->with('success', 'Réponse supprimée.');
    }

    public function toggleTopicLike(ForumTopic $topic)
    {
        $like = $topic->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
        } else {
            $topic->likes()->create(['user_id' => auth()->id()]);
        }

        return back();
    }

    public function toggleCommentLike(ForumComment $comment)
    {
        $like = $comment->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
        } else {
            $comment->likes()->create(['user_id' => auth()->id()]);
        }

        return back();
    }
}
