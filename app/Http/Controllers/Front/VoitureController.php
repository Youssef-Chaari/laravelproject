<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Marque;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class VoitureController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicule::with('marque');

        if ($request->filled('marque')) {
            $query->where('marque_id', $request->marque);
        }
        if ($request->filled('budget')) {
            $query->where('prix', '<=', $request->budget);
        }
        if ($request->filled('carburant')) {
            $query->where('carburant', $request->carburant);
        }
        if ($request->filled('q')) {
            $query->where('modele', 'like', '%' . $request->q . '%');
        }

        $vehicules = $query->latest()->paginate(12);
        $marques = Marque::orderBy('nom')->get();

        return view('cars-new.index', compact('vehicules', 'marques'));
    }

    public function marque(string $slug)
    {
        $marque    = Marque::where('slug', $slug)->firstOrFail();
        $vehicules = Vehicule::where('marque_id', $marque->id)->get();
        return view('cars-new.marque', compact('marque', 'vehicules'));
    }

    public function show(string $marqueSlug, string $vehiculeSlug)
    {
        $marque   = Marque::where('slug', $marqueSlug)->firstOrFail();
        $vehicule = Vehicule::where('marque_id', $marque->id)
                            ->where('slug', $vehiculeSlug)
                            ->firstOrFail();
        return view('cars-new.show', compact('marque', 'vehicule'));
    }

    public function compare(Request $request)
    {
        $vehiculeIds = $request->input('ids', []);
        $vehiculesToCompare = collect([]);

        if (!empty($vehiculeIds)) {
            $vehiculesToCompare = Vehicule::with('marque')->whereIn('id', $vehiculeIds)->get();
        }

        // For the dropdown selector
        $allMarques = Marque::with('vehicules')->orderBy('nom')->get();

        return view('cars-new.comparer', compact('vehiculesToCompare', 'allMarques', 'vehiculeIds'));
    }
}
