<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarUsedRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array
    {
        return [
            'brand'       => 'required|string|max:100',
            'model'       => 'required|string|max:100',
            'year'        => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'price'       => 'required|numeric|min:0',
            'mileage'     => 'required|integer|min:0',
            'description' => 'nullable|string',
            'images'      => 'nullable|array|max:10',
            'images.*'    => 'image|mimes:jpeg,jpg,png,webp|max:4096',
        ];
    }
}
