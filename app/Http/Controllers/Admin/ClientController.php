<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::where('role', '!=', 'admin')
            ->withCount('annonces')
            ->latest()
            ->paginate(20);

        return view('admin.clients.index', compact('clients'));
    }

    public function show(User $client)
    {
        $client->load('annonces');
        return view('admin.clients.show', compact('client'));
    }

    public function toggle(User $client)
    {
        $client->statut = $client->statut === 'actif' ? 'inactif' : 'actif';
        $client->save();
        return back()->with('success', 'Statut mis à jour.');
    }
}
