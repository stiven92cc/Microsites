<?php

namespace App\PaymentGateway;


use App\Constants\MicrositeTypes;
use App\Constants\PaymentStatus;
use App\Contracts\PaymentGatewayContract;
use App\Infrastructure\Persistence\Models\Microsite;
use App\Infrastructure\Persistence\Models\Subscription;
use App\Jobs\ResolveInvoiceJob;
use Dnetix\Redirection\Entities\Transaction;
use Dnetix\Redirection\Message\RedirectResponse;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Infrastructure\Persistence\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Throwable;

class PlacetopayGateway implements PaymentGatewayContract
{
    public PlacetoPay $placetopay;

    public function connection(array $settings): self
    {
        $this->placetopay = $this->getPlacetoPay($settings);
        return $this;
    }

    protected function getPlacetoPay(array $settings): PlacetoPay {
        return new PlacetoPay([
            'login' => Arr::get($settings, 'login'),
            'tranKey' => Arr::get($settings, 'tranKey'),
            'baseUrl' => Arr::get($settings, 'baseUrl'),
            'timeout' => 10,
        ]);
    }
    public function createSession(Payment $payment, Request $request)
    {
        try {
            $requestData = [
                'expiration' => date('c', strtotime('+30 minutes')),
                'returnUrl' => route('payment.detail', $payment->id),
                'ipAddress' => $request->ip(),
                'userAgent' => $request->userAgent(),
            ];

            if (Microsite::find($payment->microsite_id)->type === MicrositeTypes::SUBSCRIPTION) {
                $data = $request->toArray();
                $requestData['payer'] = [
                    'document' => $data['payer_document'],
                    'documentType' => $data['payer_document_type'],
                    'name' => $data['payer_name'],
                    'surname' => $data['payer_last_name'],
                    'email' => $data['payer_email'],
                    'mobile' => $data['phone_number'],
                ];
                $requestData['subscription'] = [
                    'reference' => $data['subscription']['reference'],
                    'description' => 'nueva subscripcion',
                ];
                Subscription::create([
                    'subscription_plan_id' => $data['subscription']['id'],
                    'payment_id' => $payment->id
                ]);
            } else {
                $requestData['payment'] = [
                    'reference' => $payment->reference,
                    'description' => $payment->description,
                    'amount' => [
                        'currency' => 'COP',
                        'total' => $payment->amount,
                    ]
                ];
            }
            /** @var RedirectResponse $response */
            $response = $this->placetopay->request($requestData);

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
            dd($exception);
            report($exception);
        }
    }
    public function query(Payment $payment): Payment
    {
        $response = $this->placetopay->query($payment->request_id);
        $microsite = Microsite::find($payment->microsite_id);
        try {
            if ($response->isSuccessful()) {
                if ($response->status()->isApproved()) {
                    $payment->status = PaymentStatus::APPROVED->value;
                    $payment->paid_at = new Carbon($response->status()->date());
                    if ($microsite->type === MicrositeTypes::SUBSCRIPTION) {
                        $instrumentData = $response->subscription()->instrumentToArray();

                        $subscription = $payment->subscription;
                        $subscription->status = PaymentStatus::APPROVED->value;
                        $subscription->token = Crypt::encrypt($instrumentData[0]['value']);
                        $subscription->sub_token = Crypt::encrypt($instrumentData[1]['value']);
                        $subscription->lastDigits = Crypt::encrypt($instrumentData[5]['value']);
                        $subscription->validUntil = $instrumentData[6]['value'];
                        $subscription->save();
                    } elseif ($microsite->type === MicrositeTypes::INVOICE) {
                        $payment->receipt = $response->lastApprovedTransaction()->receipt();
                      ResolveInvoiceJob::dispatch($payment);
                    } else {
                        $payment->receipt = $response->lastApprovedTransaction()->receipt();
                    }
                } elseif ($response->status()->isRejected()) {
                    $payment->status = PaymentStatus::REJECTED->value;
                }
                $payment->save();
            }
        } catch (Throwable $exception) {
            dd($exception);
        }
        return $payment;
    }
}
