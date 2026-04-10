<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Marque;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MarqueController extends Controller
{
    public function index()
    {
        $marques = Marque::withCount('vehicules')->orderBy('nom')->paginate(20);
        return view('admin.marques.index', compact('marques'));
    }

    public function create()
    {
        return view('admin.marques.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'     => 'required|string|max:100',
            'pays'    => 'nullable|string|max:100',
            'couleur' => 'nullable|string|max:20',
            'logo'    => 'nullable|image|max:2048',
        ]);

        $data['slug'] = Str::slug($data['nom']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('marques', 'public');
        }

        Marque::create($data);

        return redirect()->route('admin.marques.index')->with('success', 'Marque créée.');
    }

    public function edit(Marque $marque)
    {
        return view('admin.marques.edit', compact('marque'));
    }

    public function update(Request $request, Marque $marque)
    {
        $data = $request->validate([
            'nom'     => 'required|string|max:100',
            'pays'    => 'nullable|string|max:100',
            'couleur' => 'nullable|string|max:20',
            'logo'    => 'nullable|image|max:2048',
        ]);

        $data['slug'] = Str::slug($data['nom']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('marques', 'public');
        }

        $marque->update($data);

        return redirect()->route('admin.marques.index')->with('success', 'Marque mise à jour.');
    }

    public function destroy(Marque $marque)
    {
        $marque->delete();
        return redirect()->route('admin.marques.index')->with('success', 'Marque supprimée.');
    }
}
