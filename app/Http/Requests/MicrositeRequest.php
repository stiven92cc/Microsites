<?php

namespace App\Http\Requests;

use App\Constants\CurrencyTypes;
use App\Constants\MicrositeTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MicrositeRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:microsites',
            'logo' => 'nullable|string|max:100',
            'category_id' => 'required|integer|exists:categories,id',
            'type' => ['required|string|max:50', Rule::in(MicrositeTypes::getTypes())],
            'currency' => ['required|string|max:3', Rule::in(CurrencyTypes::getTypes())],
            'payment_expiration' => 'required|integer',

        ];
    }
}
