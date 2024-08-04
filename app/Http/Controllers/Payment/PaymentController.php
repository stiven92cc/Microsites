<?php

namespace App\Http\Controllers\Payment;

use App\Constants\CurrencyTypes;
use App\Constants\DocumentTypes;
use App\Contracts\PaymentGatewayContract;
use App\Infrastructure\Persistence\Models\Microsite;
use App\Infrastructure\Persistence\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController
{
    public function micrositeForm(Microsite $microsite): Response
    {
        return Inertia::render(
            'MicrositesForms/' . ucfirst($microsite->type),
            [
                'microsite' => $microsite,
                'documentTypes' => DocumentTypes::getTypes(),
                'currencyTypes' => CurrencyTypes::getTypes()
            ]
        );
    }

    public function index(): Response
    {
        $payments = Payment::all();
        return Inertia::render('Payments/Index', ['payments' => $payments]);
    }

    public function show(Payment $payment): Response
    {
        $microsite = Microsite::query()->where('id', $payment->microsite_id)->first();

        return Inertia::render('Payments/Show', [
            'payment' => $payment,
            'microsite' => $microsite,
        ]);
    }

    public function pay(Request $request, Microsite $microsite, PaymentGatewayContract $gateway)
    {
        $data = $request->toArray();

        do {
            $reference = Str::random(40);
        } while (Payment::where('reference', $reference)->exists());

        $data['reference'] = $reference;
        $data['microsite_id'] = $microsite->id;

        $payment = $gateway->createSession(Payment::create($data), $request);
        return $payment->status=='pending' ? Inertia::location($payment->process_url) : dd('hola');
    }
}
