<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarUsedRequest;
use App\Http\Requests\UpdateCarUsedRequest;
use App\Models\CarUsed;
use App\Models\CarImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarUsedController extends Controller
{
    public function index(Request $request)
    {
        $query = CarUsed::approved()->with('primaryImage', 'user');

        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $cars   = $query->latest()->paginate(12)->withQueryString();
        $brands = CarUsed::approved()->distinct()->orderBy('brand')->pluck('brand');

        return view('cars-used.index', compact('cars', 'brands'));
    }

    public function show(CarUsed $car)
    {
        abort_if($car->status !== 'approved', 404);
        $car->load('images', 'user');
        return view('cars-used.show', compact('car'));
    }

    public function create()
    {
        return view('cars-used.create');
    }

    public function store(StoreCarUsedRequest $request)
    {
        $car = CarUsed::create([
            ...$request->safe()->except('images'),
            'user_id' => auth()->id(),
            'status'  => 'pending',
        ]);

        $this->uploadImages($request, $car);

        return redirect()->route('my-ads')->with('success', 'Votre annonce a été soumise et est en attente de validation.');
    }

    public function edit(CarUsed $car)
    {
        $this->authorize('update', $car);
        $car->load('images');
        return view('cars-used.edit', compact('car'));
    }

    public function update(UpdateCarUsedRequest $request, CarUsed $car)
    {
        $this->authorize('update', $car);
        $car->update($request->safe()->except('images'));
        $car->update(['status' => 'pending']); // re-validate after edit

        $this->uploadImages($request, $car);

        return redirect()->route('my-ads')->with('success', 'Annonce mise à jour. En attente de validation.');
    }

    public function destroy(CarUsed $car)
    {
        $this->authorize('delete', $car);

        foreach ($car->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        $car->images()->delete();
        $car->delete();

        return redirect()->route('my-ads')->with('success', 'Annonce supprimée avec succès.');
    }

    public function myAds()
    {
        $cars = CarUsed::where('user_id', auth()->id())->with('primaryImage')->latest()->paginate(10);
        return view('cars-used.my-ads', compact('cars'));
    }

    private function uploadImages(Request $request, CarUsed $car): void
    {
        if ($request->hasFile('images')) {
            $first = true;
            foreach ($request->file('images') as $file) {
                $path = $file->store('cars', 'public');
                $car->images()->create([
                    'path'       => $path,
                    'is_primary' => $first,
                ]);
                $first = false;
            }
        }
    }
}
