<?php

namespace App\Http\Requests\Microsites;

use Illuminate\Foundation\Http\FormRequest;

class StoreMicrositeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:microsites',
            'logo' => 'nullable|string|max:100',
            'category_id' => 'nullable|integer|exists:categories,id',
            'type' => 'required|string|max:50',
            'currency' => 'required|string|max:3',
            'payment_expiration' => 'required|integer',

        ];
    }
}
