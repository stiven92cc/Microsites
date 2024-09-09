<?php

namespace App\Http\Requests\Users;

use App\Constants\DocumentTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:50',
            'password' => 'required|string|confirmed',
            'document' => 'required|string|',
            'document_type' => ['required','string', Rule::in(DocumentTypes::getTypes())],
            'role' => 'required|string|',
        ];
    }
}
