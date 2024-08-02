<?php

namespace App\Http\Controllers\Payment;

use App\Constants\DocumentTypes;
use App\Infrastructure\Persistence\Models\Microsite;
use App\Infrastructure\Persistence\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PaymentController
{
    public function micrositeForm(Microsite $microsite)
    {
        return Inertia::render(
            'MicrositesForms/' . ucfirst($microsite->type),
            [
                'microsite' => $microsite,
                'documentTypes' => DocumentTypes::getTypes()
            ]
        );
    }

    public function pay(Request $request, Microsite $microsite)
    {
        $data = $request->toArray();

        do {
            $reference = Str::random(40);
        } while (Payment::where('reference', $reference)->exists());

        $data['reference'] = $reference;
        $data['microsite_id'] = $microsite->id;

        $payment = Payment::create($data);
        $payment->save();
    }
}
