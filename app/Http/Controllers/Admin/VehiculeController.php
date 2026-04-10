<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicule;
use App\Models\Marque;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::with('marque')->latest()->paginate(15);
        $marques   = Marque::orderBy('nom')->get();
        return view('admin.vehicules.index', compact('vehicules', 'marques'));
    }

    public function create()
    {
        $marques = Marque::orderBy('nom')->get();
        return view('admin.vehicules.create', compact('marques'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'marque_id'    => 'required|exists:marques,id',
            'modele'       => 'required|string|max:100',
            'annee'        => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'prix'         => 'required|numeric|min:0',
            'carburant'    => 'required|in:essence,diesel,hybride,electrique,gpl',
            'puissance'    => 'nullable|integer|min:0',
            'couple'       => 'nullable|integer|min:0',
            'transmission' => 'required|in:manuelle,automatique',
            'consommation' => 'nullable|numeric|min:0',
            'nb_portes'    => 'nullable|integer|min:2|max:5',
            'nb_places'    => 'nullable|integer|min:1|max:9',
            'volume_coffre'=> 'nullable|integer|min:0',
            'couleur'      => 'nullable|string|max:50',
            'couleur_bg'   => 'nullable|string|max:7',
            'kilometrage'  => 'nullable|integer|min:0',
            'garantie'     => 'nullable|integer|min:0',
            'description'  => 'nullable|string',
            'equipements'  => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['modele'] . '-' . $data['annee'] . '-' . Str::random(4));
        
        if ($request->filled('equipements')) {
            $data['equipements'] = array_map('trim', explode(',', $request->equipements));
        } else {
            $data['equipements'] = [];
        }

        Vehicule::create($data);

        return redirect()->route('admin.vehicules.index')->with('success', 'Véhicule ajouté.');
    }

    public function edit(Vehicule $vehicule)
    {
        $marques = Marque::orderBy('nom')->get();
        return view('admin.vehicules.edit', compact('vehicule', 'marques'));
    }

    public function update(Request $request, Vehicule $vehicule)
    {
        $data = $request->validate([
            'marque_id'    => 'required|exists:marques,id',
            'modele'       => 'required|string|max:100',
            'annee'        => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'prix'         => 'required|numeric|min:0',
            'carburant'    => 'required|in:essence,diesel,hybride,electrique,gpl',
            'puissance'    => 'nullable|integer|min:0',
            'couple'       => 'nullable|integer|min:0',
            'transmission' => 'required|in:manuelle,automatique',
            'consommation' => 'nullable|numeric|min:0',
            'nb_portes'    => 'nullable|integer|min:2|max:5',
            'nb_places'    => 'nullable|integer|min:1|max:9',
            'volume_coffre'=> 'nullable|integer|min:0',
            'couleur'      => 'nullable|string|max:50',
            'couleur_bg'   => 'nullable|string|max:7',
            'kilometrage'  => 'nullable|integer|min:0',
            'garantie'     => 'nullable|integer|min:0',
            'description'  => 'nullable|string',
            'equipements'  => 'nullable|string',
        ]);

        if ($request->filled('equipements')) {
            $data['equipements'] = array_map('trim', explode(',', $request->equipements));
        } else {
            $data['equipements'] = [];
        }

        if ($data['modele'] !== $vehicule->modele || (int)$data['annee'] !== (int)$vehicule->annee) {
            $data['slug'] = Str::slug($data['modele'] . '-' . $data['annee'] . '-' . Str::random(4));
        }

        $vehicule->update($data);

        return redirect()->route('admin.vehicules.index')->with('success', 'Véhicule mis à jour.');
    }

    public function destroy(Vehicule $vehicule)
    {
        $vehicule->delete();
        return redirect()->route('admin.vehicules.index')->with('success', 'Véhicule supprimé.');
    }
}
