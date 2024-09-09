<?php

namespace App\Jobs;

use App\Constants\InvoicesStatus;
use App\Constants\PaymentStatus;
use App\Infrastructure\Persistence\Models\Invoice;
use App\Infrastructure\Persistence\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResolveInvoiceJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected Payment $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function handle(): void
    {
        $invoice = $this->payment->invoice()->first();
        if ($this->payment->status === PaymentStatus::PENDING->value) {
            $invoice->status = InvoicesStatus::PENDING_PAYMENT;
        } elseif ($this->payment->status === PaymentStatus::APPROVED->value) {
            $invoice->status = InvoicesStatus::COMPLETED;
        }

        $invoice->save();
    }
}
