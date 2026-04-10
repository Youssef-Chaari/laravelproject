<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumTopic;
use App\Models\ForumComment;

class ForumController extends Controller
{
    public function index()
    {
        $topics = ForumTopic::with('user')->withCount('comments')->latest()->paginate(20);
        return view('admin.forum.index', compact('topics'));
    }

    public function destroyTopic(ForumTopic $topic)
    {
        $topic->delete();
        return redirect()->route('admin.forum.index')->with('success', 'Sujet supprimé.');
    }

    public function destroyComment(ForumComment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Commentaire supprimé.');
    }
}
