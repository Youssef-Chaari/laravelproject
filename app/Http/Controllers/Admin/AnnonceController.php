<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    /**
     * Affiche la liste de toutes les annonces, avec en priorité celles en attente.
     */
    public function index()
    {
        // En attente en premier, puis les plus récentes
        $annonces = Annonce::with(['user', 'marque'])
            ->orderByRaw("FIELD(statut, 'attente', 'publie', 'rejete')")
            ->latest()
            ->paginate(20);

        return view('admin.annonces.index', compact('annonces'));
    }

    /**
     * Affiche les détails d'une annonce pour modération
     */
    public function show(Annonce $annonce)
    {
        $annonce->load('user', 'marque', 'images');
        return view('admin.annonces.show', compact('annonce'));
    }

    /**
     * Valide une annonce (statut => publie)
     */
    public function validateAd(Annonce $annonce)
    {
        $annonce->update(['statut' => 'publie']);

        return redirect()->route('admin.annonces.index')->with('success', 'Annonce validée et publiée.');
    }

    /**
     * Rejette une annonce (statut => rejete)
     */
    public function rejectAd(Annonce $annonce)
    {
        $annonce->update(['statut' => 'rejete']);

        return redirect()->route('admin.annonces.index')->with('success', 'Annonce rejetée.');
    }

    /**
     * Supprime définitivement une annonce
     */
    public function destroy(Annonce $annonce)
    {
        $annonce->delete();

        return redirect()->route('admin.annonces.index')->with('success', 'Annonce supprimée définitivement.');
    }
}
