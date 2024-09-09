<?php

namespace App\Http\Requests;

use App\Constants\CurrencyTypes;
use App\Constants\MicrositeTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MicrositeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'type' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'payment_expiration' => 'required|integer|min:3',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
