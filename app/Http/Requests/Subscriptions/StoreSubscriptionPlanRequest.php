<?php

namespace App\Http\Requests\Subscriptions;

use App\Constants\CurrencyTypes;
use App\Constants\SubscriptionPeriods;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubscriptionPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'descriptions' => ['required', 'array'],
            'amount' => ['required', 'numeric', 'min:0'],
            'subscription_period' => ['required', 'in:' . implode(',', SubscriptionPeriods::getAllSubscriptionPeriods())],
            'expiration_time' => ['required', 'integer', 'min:1'],
            'microsite_id' => ['required', 'exists:microsites,id'],
        ];
    }

    //public function messages(): array
   // {
        //return [
          //  'name.required' => 'El nombre del plan es obligatorio.',
            //'description.required' => 'La descripción es obligatoria.',
            //'amount.required' => 'El monto es obligatorio.',
            //'subscription_period.required' => 'El período de suscripción es obligatorio.',
            //'expiration_time.required' => 'El tiempo de expiración es obligatorio.',
            //'microsite_id.required' => 'El micrositio es obligatorio.',
            //'microsite_id.exists' => 'El micrositio seleccionado no es válido.',
      //  ];
    //}
}
