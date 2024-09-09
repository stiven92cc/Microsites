<?php

namespace App\Console\Commands;

use App\Constants\PaymentStatus;
use App\Infrastructure\Persistence\Models\Payment;
use App\Jobs\ResolvePaymentJob;
use Illuminate\Console\Command;

class ResolveTransactions extends Command
{
    protected $signature = 'app:resolve-transactions';

    protected $description = 'Command description';

    public function handle()
    {
        $payments = Payment::where('status', PaymentStatus::PENDING)->get();
        foreach ($payments as $payment) {
            ResolvePaymentJob::dispatch($payment);
        }
    }
}
