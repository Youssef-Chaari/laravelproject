<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumTopic;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index()
    {
        $topics = ForumTopic::with('user')->withCount('comments')->latest()->paginate(20);
        return view('admin.forum.index', compact('topics'));
    }

    public function destroy(ForumTopic $topic)
    {
        $topic->delete();
        return redirect()->route('admin.forum.index')->with('success', 'Sujet supprimé avec succès.');
    }
}
