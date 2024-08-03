<?php

namespace App\PaymentGateway;


use App\Constants\PaymentStatus;
use App\Contracts\PaymentGatewayContract;
use Dnetix\Redirection\Message\RedirectResponse;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Infrastructure\Persistence\Models\Payment;
use Illuminate\Support\Carbon;
use Throwable;

class PlacetopayGateway implements PaymentGatewayContract
{
    protected PlacetoPay $placetopay;

    public function connection(array $settings): self
    {
        $this->placetopay = new PlacetoPay([
            'login' => Arr::get($settings, 'login'),
            'tranKey' => Arr::get($settings, 'tranKey'),
            'baseUrl' => Arr::get($settings, 'baseUrl'),
            'timeout' => 10,
        ]);
        return $this;
    }

    public function createSession(Payment $payment, Request $request)
    {
        $totalPrice = $payment->amount;
        try {
            $request = [
                'payment' => [
                    'reference' => '12321313',
                    'description' => $payment->description,
                    'amount' => [
                        'currency' => 'COP',
                        'total' => $totalPrice,
                    ],
                ],
                'expiration' => date('c', strtotime('+30 minutes')),
                'returnUrl' => route('welcome'),
                'ipAddress' => $request->ip(),
                'userAgent' => $request->userAgent(),
            ];
            /** @var RedirectResponse $response */
            $response = $this->placetopay->request($request);

            if ($response->isSuccessful()) {
                $payment->process_url = $response->processUrl();
                $payment->request_id = $response->requestId();
                $payment->status = 'pending';
                $payment->save();
            } else {
                $payment->status = 'rejected';
                $payment->save();
            }

            return $payment;
        } catch (Throwable $exception) {
            report($exception);
        }
    }

    public function query(Payment $payment): Payment
    {
        $response = $this->placetopay->query($payment->request_id);
        try {
            if ($response->isSuccessful()) {
                if ($response->status()->isApproved()) {
                    $payment->status = PaymentStatus::APPROVED->value;
                    $payment->paid_at = new Carbon($response->status()->date());
                    $payment->receipt = Arr::get($response->payment(), 'receipt');
                } elseif ($response->status()->isRejected()) {
                    $payment->status = PaymentStatus::REJECTED->value;
                }
                $payment->save();
            }
        } catch (Throwable $exception) {
        }
        return $payment;
    }
}
