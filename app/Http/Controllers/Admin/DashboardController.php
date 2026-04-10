<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Marque;
use App\Models\Vehicule;
use App\Models\Annonce;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'marques'   => Marque::count(),
            'vehicules' => Vehicule::count(),
            'clients'   => User::where('role', '!=', 'admin')->count(),
            'annonces'  => Annonce::count(),
        ];

        $activiteRecente = collect([]);
        $noteSysteme     = null;

        return view('admin.dashboard', compact('stats', 'activiteRecente', 'noteSysteme'));
    }
}
