{{-- Shared form fields for create/edit used car --}}
@php $car = $car ?? null; @endphp

<div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 mb-6">
    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-6 pb-4 border-b border-slate-100">Informations du véhicule</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
            <label class="form-label">Marque *</label>
            <input type="text" name="brand" value="{{ old('brand', $car?->brand) }}" required class="form-input" placeholder="ex: Toyota">
            @error('brand')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Modèle *</label>
            <input type="text" name="model" value="{{ old('model', $car?->model) }}" required class="form-input" placeholder="ex: Yaris">
            @error('model')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Année *</label>
            <input type="number" name="year" value="{{ old('year', $car?->year) }}" required min="1990" max="{{ date('Y') }}" class="form-input">
            @error('year')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="form-label">Prix (DH) *</label>
            <input type="number" name="price" value="{{ old('price', $car?->price) }}" required min="0" step="0.01" class="form-input">
            @error('price')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="sm:col-span-2">
            <label class="form-label">Kilométrage *</label>
            <input type="number" name="mileage" value="{{ old('mileage', $car?->mileage) }}" required min="0" class="form-input">
            @error('mileage')<p class="form-error">{{ $message }}</p>@enderror
        </div>
    </div>
</div>

<div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 mb-6">
    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-6 pb-4 border-b border-slate-100">Détails de l'annonce</h3>
    <div>
        <label class="form-label">Description détaillée</label>
        <textarea name="description" rows="5" class="form-input resize-none" placeholder="Décrivez l'état de votre véhicule, les options, l'entretien récent...">{{ old('description', $car?->description) }}</textarea>
        @error('description')<p class="form-error">{{ $message }}</p>@enderror
    </div>
</div>

<div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-6 pb-4 border-b border-slate-100">Galerie Photos</h3>
    <div>
        <label class="form-label">Photos (max 10, JPG/PNG/WebP, 4Mo max)</label>
        <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors">
            <div class="space-y-1 text-center w-full">
                <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="flex text-sm text-slate-600 justify-center">
                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                        <span>Télécharger un ou plusieurs fichiers</span>
                        <input id="file-upload" type="file" name="images[]" multiple accept="image/*" class="sr-only">
                    </label>
                </div>
                <p class="text-xs text-slate-500">PNG, JPG, WEBP jusqu'à 4MB</p>
            </div>
        </div>
        @error('images.*')<p class="form-error">{{ $message }}</p>@enderror

        @if($car && $car->images->count())
            <div class="mt-6">
                <p class="text-sm font-medium text-slate-700 mb-3">Photos actuelles :</p>
                <div class="flex gap-3 overflow-x-auto pb-2">
                    @foreach($car->images as $img)
                        <img src="{{ Storage::url($img->path) }}" class="w-24 h-16 object-cover rounded-xl border border-slate-200 shadow-sm flex-shrink-0">
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
