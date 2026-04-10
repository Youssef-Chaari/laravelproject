<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Marque;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    public function index(Request $request)
    {
        $query   = Annonce::published()->with('user', 'marque');

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->q . '%')
                  ->orWhere('modele', 'like', '%' . $request->q . '%');
            });
        }
        if ($request->filled('marque')) {
            $query->where('marque_id', $request->marque);
        }
        if ($request->filled('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }

        $annonces = $query->latest()->paginate(12)->withQueryString();
        $marques  = Marque::orderBy('nom')->get();

        return view('cars-used.index', compact('annonces', 'marques'));
    }

    public function create()
    {
        $marques = Marque::orderBy('nom')->get();
        return view('cars-used.create', compact('marques'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'marque_id'   => 'required|exists:marques,id',
            'modele'      => 'required|string|max:100',
            'annee'       => 'required|integer|min:1990|max:' . date('Y'),
            'kilometrage' => 'required|integer|min:0',
            'prix'        => 'required|numeric|min:0',
            'carburant'   => 'required|in:essence,diesel,hybride,electrique,gpl',
            'transmission'=> 'required|in:manuelle,automatique',
            'puissance'   => 'required|integer|min:1',
            'description' => 'nullable|string',
            'nom'         => 'required|string|max:100',
            'telephone'   => 'required|string|max:20',
        ]);

        $marque = Marque::find($validated['marque_id']);

        Annonce::create([
            'user_id'     => auth()->id(),
            'marque_id'   => $validated['marque_id'],
            'titre'       => ($marque->nom ?? '') . ' ' . $validated['modele'] . ' ' . $validated['annee'],
            'modele'      => $validated['modele'],
            'annee'       => $validated['annee'],
            'kilometrage' => $validated['kilometrage'],
            'prix'        => $validated['prix'],
            'carburant'   => $validated['carburant'],
            'transmission'=> $validated['transmission'],
            'puissance'   => $validated['puissance'],
            'description' => $validated['description'] ?? null,
            'telephone'   => $validated['telephone'],
            'statut'      => 'publie',
        ]);

        return redirect()->route('occasions.index')->with('success', 'Annonce publiée !');
    }

    public function show(Annonce $annonce)
    {
        $annonce->load('user', 'marque');
        return view('cars-used.show', compact('annonce'));
    }
}
