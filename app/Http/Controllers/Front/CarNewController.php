<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CarNew;
use Illuminate\Http\Request;

class CarNewController extends Controller
{
    public function index(Request $request)
    {
        $query = CarNew::with('primaryImage');

        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }

        $cars   = $query->latest()->paginate(12)->withQueryString();
        $brands = CarNew::distinct()->orderBy('brand')->pluck('brand');

        return view('cars-new.index', compact('cars', 'brands'));
    }

    public function show(CarNew $car)
    {
        $car->load('images');
        $related = CarNew::where('brand', $car->brand)->where('id', '!=', $car->id)->take(3)->get();
        return view('cars-new.show', compact('car', 'related'));
    }
}
