@php $car = $car ?? null; @endphp

<div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 mb-6">
    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-6 pb-4 border-b border-slate-100">Informations Principales</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
            <label class="form-label">Marque *</label>
            <input type="text" name="brand" value="{{ old('brand', $car?->brand) }}" required class="form-input" placeholder="ex: Renault">
            @error('brand')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Modèle *</label>
            <input type="text" name="model" value="{{ old('model', $car?->model) }}" required class="form-input" placeholder="ex: Clio 5">
            @error('model')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Année *</label>
            <input type="number" name="year" value="{{ old('year', $car?->year) }}" required min="1990" max="{{ date('Y') + 1 }}" class="form-input">
            @error('year')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Prix (DH) *</label>
            <input type="number" name="price" value="{{ old('price', $car?->price) }}" required min="0" step="0.01" class="form-input" placeholder="ex: 150000">
            @error('price')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Puissance (ch)</label>
            <input type="number" name="horsepower" value="{{ old('horsepower', $car?->horsepower) }}" min="1" class="form-input" placeholder="ex: 110">
        </div>
        <div>
            <label class="form-label">Carburant *</label>
            <select name="fuel_type" class="form-input">
                @foreach(['essence','diesel','electrique','hybride','gpl'] as $fuel)
                    <option value="{{ $fuel }}" {{ old('fuel_type', $car?->fuel_type) === $fuel ? 'selected' : '' }}>{{ ucfirst($fuel) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label">Transmission *</label>
            <select name="transmission" class="form-input">
                <option value="manuelle" {{ old('transmission', $car?->transmission) === 'manuelle' ? 'selected' : '' }}>Manuelle</option>
                <option value="automatique" {{ old('transmission', $car?->transmission) === 'automatique' ? 'selected' : '' }}>Automatique</option>
            </select>
        </div>
    </div>
</div>

<div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 mb-6">
    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-6 pb-4 border-b border-slate-100">Détails Additionnels</h3>
    <div>
        <label class="form-label">Description</label>
        <textarea name="description" rows="5" class="form-input resize-none" placeholder="Description du véhicule, finitions, options incluses...">{{ old('description', $car?->description) }}</textarea>
    </div>
</div>

<div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 mb-6">
    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-6 pb-4 border-b border-slate-100">Médias</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <label class="form-label font-bold text-slate-800">Image principale (Vignette)</label>
            @if($car && $car->thumbnail)
                <div class="mb-3">
                    <p class="text-sm text-slate-500 mb-2">Image actuelle :</p>
                    <img src="{{ Storage::url($car->thumbnail) }}" class="w-32 h-24 object-cover rounded-xl shadow-sm border border-slate-200">
                </div>
            @endif
            <input type="file" name="thumbnail" accept="image/*" class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
        </div>
        <div>
            <label class="form-label font-bold text-slate-800">Galerie d'images complémentaires</label>
            @if($car && $car->images->count())
                <div class="mb-3">
                    <p class="text-sm text-slate-500 mb-2">Galerie actuelle :</p>
                    <div class="flex gap-2 flex-wrap">
                        @foreach($car->images as $img)
                            <img src="{{ Storage::url($img->path) }}" class="w-20 h-14 object-cover rounded-lg shadow-sm border border-slate-200">
                        @endforeach
                    </div>
                </div>
            @endif
            <input type="file" name="images[]" multiple accept="image/*" class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
        </div>
    </div>
</div>
