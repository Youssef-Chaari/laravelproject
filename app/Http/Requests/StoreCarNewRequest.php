<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarNewRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'brand'        => 'required|string|max:100',
            'model'        => 'required|string|max:100',
            'year'         => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'price'        => 'required|numeric|min:0',
            'description'  => 'nullable|string',
            'horsepower'   => 'nullable|integer|min:1',
            'fuel_type'    => 'required|in:essence,diesel,electrique,hybride,gpl',
            'transmission' => 'required|in:manuelle,automatique',
            'images'       => 'nullable|array|max:10',
            'images.*'     => 'image|mimes:jpeg,jpg,png,webp|max:4096',
            'thumbnail'    => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
        ];
    }
}
