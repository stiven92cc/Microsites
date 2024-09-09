<?php

namespace App\Http\Controllers\Payment;

use App\Constants\CurrencyTypes;
use App\Constants\DocumentTypes;
use App\Constants\MicrositeTypes;
use App\Contracts\PaymentGatewayContract;
use App\Infrastructure\Persistence\Models\Invoice;
use App\Infrastructure\Persistence\Models\Microsite;
use App\Infrastructure\Persistence\Models\Payment;
use App\Jobs\ResolvePaymentJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                'microsite' => $microsite->load('subscriptionPlans'),
                'user' => Auth::user() ?? null,
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
        $data = $request->except(['subscription']);
        do {
            $reference = Str::random(20);
        } while (Payment::where('reference', $reference)->exists());

        $data['reference'] = $reference;
        $data['microsite_id'] = $microsite->id;

        $payment = $gateway->createSession(Payment::create($data), $request);

        if ($payment->status === 'pending') {
            return Inertia::location($payment->process_url);
        }

        return response()->json(['error' => 'Payment creation failed'], 500);
    }

    public function payInvoice(Request $request, Invoice $invoice, PaymentGatewayContract $gateway)
    {
        $data = $invoice->only([
            'user_id', 'reference', 'description', 'microsite_id', 'amount',
        ]);

        $payment = $gateway->createSession(Payment::create($data), $request);
        $payment->invoice_id = $invoice->id;
        $payment->save();
        if ($payment->status === 'pending') {
            return Inertia::location($payment->process_url);
        }

        return response()->json(['error' => 'Payment creation failed'], 500);
    }

    public function detail(Payment $payment, PaymentGatewayContract $gateway): Response
    {
        $microsite = Microsite::query()->where('id', $payment->microsite_id)->first();
        $gateway->query($payment);


        return Inertia::render('Payments/Detail', [
            'payment' => $payment,
            'microsite' => $microsite,
        ]);
    }
}
