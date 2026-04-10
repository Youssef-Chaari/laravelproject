<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Marque;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $marques = Marque::withCount('vehicules')->orderBy('nom')->get();
        return view('home.index', compact('marques'));
    }
}
