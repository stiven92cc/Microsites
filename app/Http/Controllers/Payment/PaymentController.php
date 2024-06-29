<?php

namespace App\Http\Controllers\Payment;

use App\Constants\CurrencyTypes;
use App\Constants\DocumentTypes;
use App\Constants\MicrositeTypes;
use App\Infrastructure\Persistence\Models\Microsite;
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
}
