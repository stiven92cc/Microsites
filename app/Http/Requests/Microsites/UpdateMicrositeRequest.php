<?php

namespace App\Http\Requests\Microsites;

use App\Constants\CurrencyTypes;
use App\Constants\MicrositeTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMicrositeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['max:100'],
            'slug' => ['string', 'max:100'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'type' => ['string', 'max:50', Rule::in(MicrositeTypes::getTypes())],
            'currency' => ['string', 'max:3', Rule::in(CurrencyTypes::getTypes())],
            'payment_expiration' => ['integer'],
        ];
    }
}
