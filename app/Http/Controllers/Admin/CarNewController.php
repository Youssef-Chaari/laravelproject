<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarNewRequest;
use App\Http\Requests\UpdateCarNewRequest;
use App\Models\CarNew;
use Illuminate\Support\Facades\Storage;

class CarNewController extends Controller
{
    public function index()
    {
        $cars = CarNew::latest()->paginate(15);
        return view('admin.cars-new.index', compact('cars'));
    }

    public function create()
    {
        return view('admin.cars-new.create');
    }

    public function store(StoreCarNewRequest $request)
    {
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('cars', 'public');
        }

        $car = CarNew::create([
            ...$request->safe()->except(['images', 'thumbnail']),
            'thumbnail' => $thumbnailPath,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('cars', 'public');
                $car->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.cars-new.index')->with('success', 'Voiture ajoutée avec succès.');
    }

    public function edit(CarNew $carsNew)
    {
        $carsNew->load('images');
        return view('admin.cars-new.edit', ['car' => $carsNew]);
    }

    public function update(UpdateCarNewRequest $request, CarNew $carsNew)
    {
        $data = $request->safe()->except(['images', 'thumbnail']);

        if ($request->hasFile('thumbnail')) {
            if ($carsNew->thumbnail) {
                Storage::disk('public')->delete($carsNew->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('cars', 'public');
        }

        $carsNew->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('cars', 'public');
                $carsNew->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.cars-new.index')->with('success', 'Voiture modifiée avec succès.');
    }

    public function destroy(CarNew $carsNew)
    {
        foreach ($carsNew->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        if ($carsNew->thumbnail) {
            Storage::disk('public')->delete($carsNew->thumbnail);
        }
        $carsNew->images()->delete();
        $carsNew->delete();

        return redirect()->route('admin.cars-new.index')->with('success', 'Voiture supprimée.');
    }
}
