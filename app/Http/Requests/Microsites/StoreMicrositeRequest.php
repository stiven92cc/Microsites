<?php

namespace App\Http\Requests\Microsites;

use App\Constants\CurrencyTypes;
use App\Constants\MicrositeTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMicrositeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'max:100', 'min:2'],
            'slug' => ['required', 'string', 'max:100', 'unique:microsites'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'category_id' => ['required', 'exists:categories,id'],
            'type' => ['required', 'string', 'max:50', Rule::in(MicrositeTypes::getTypes())],
            'currency' => ['required', 'string', 'max:3', Rule::in(CurrencyTypes::getTypes())],
            'payment_expiration' => ['required', 'integer'],
        ];
    }
}
