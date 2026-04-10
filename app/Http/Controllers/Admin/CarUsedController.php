<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarUsed;
use Illuminate\Support\Facades\Storage;

class CarUsedController extends Controller
{
    public function index()
    {
        $cars = CarUsed::with('user')->latest()->paginate(20);
        return view('admin.cars-used.index', compact('cars'));
    }

    public function show(CarUsed $carsUsed)
    {
        $carsUsed->load('user', 'images');
        return view('admin.cars-used.show', ['car' => $carsUsed]);
    }

    public function approve(CarUsed $carsUsed)
    {
        $carsUsed->update(['status' => 'approved']);
        return back()->with('success', 'Annonce approuvée.');
    }

    public function reject(CarUsed $carsUsed)
    {
        $carsUsed->update(['status' => 'rejected']);
        return back()->with('success', 'Annonce rejetée.');
    }

    public function destroy(CarUsed $carsUsed)
    {
        foreach ($carsUsed->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        $carsUsed->images()->delete();
        $carsUsed->forceDelete();

        return redirect()->route('admin.cars-used.index')->with('success', 'Annonce supprimée définitivement.');
    }
}
