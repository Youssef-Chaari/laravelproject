<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Vehicule;
use App\Models\Marque;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DevisController extends Controller
{
    public function generate(Request $request, string $marqueSlug, string $vehiculeSlug)
    {
        $request->validate([
            'nom'       => 'required|string|max:100',
            'prenom'    => 'required|string|max:100',
            'email'     => 'required|email|max:150',
            'telephone' => 'required|string|max:20',
            'message'   => 'nullable|string|max:1000',
        ]);

        $marque   = Marque::where('slug', $marqueSlug)->firstOrFail();
        $vehicule = Vehicule::with('marque', 'images')
                            ->where('marque_id', $marque->id)
                            ->where('slug', $vehiculeSlug)
                            ->firstOrFail();

        $devisData = [
            'numero'    => 'DEV-' . date('Y') . '-' . strtoupper(substr(md5(uniqid()), 0, 6)),
            'date'      => now()->format('d/m/Y'),
            'validite'  => now()->addDays(30)->format('d/m/Y'),
            'client'    => [
                'nom'       => $request->nom,
                'prenom'    => $request->prenom,
                'email'     => $request->email,
                'telephone' => $request->telephone,
                'message'   => $request->message,
            ],
            'vehicule'  => $vehicule,
            'marque'    => $marque,
        ];

        $pdf = Pdf::loadView('devis.pdf', $devisData)
                  ->setPaper('a4', 'portrait');

        $filename = 'Devis-' . $marque->nom . '-' . $vehicule->modele . '-' . date('Ymd') . '.pdf';

        return $pdf->download($filename);
    }
}
