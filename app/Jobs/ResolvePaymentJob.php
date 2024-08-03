<?php

namespace App\Jobs;

use App\Contracts\PaymentGatewayContract;
use App\Infrastructure\Persistence\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResolvePaymentJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected Payment $payment;
    protected PaymentGatewayContract $gateway;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
        $this->gateway = resolve(PaymentGatewayContract::class);
    }

    public function handle(): void
    {
        $this->gateway->query($this->payment);
    }
}
