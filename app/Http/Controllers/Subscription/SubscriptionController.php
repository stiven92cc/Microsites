<?php

namespace App\Http\Controllers\Subscription;

use App\Constants\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Infrastructure\Persistence\Models\Microsite;
use App\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with('payment', 'subscriptionPlan')->get();

        $subscriptions = $subscriptions->map(function ($subscription) {
            if ($subscription->payment) {
                $subscription->payer_name = $subscription->payment->payer_name;
                $subscription->payer_email = $subscription->payment->payer_email;
                $subscription->amount = $subscription->payment->amount;
                $subscription->currency = $subscription->payment->currency;
                $subscription->plan_frencuency = $subscription->subscriptionPlan->subscription_period;
            }

            return $subscription;
        });

        return inertia('Subscriptions/Index', [
            'subscriptions' => $subscriptions,
        ]);
    }

    public function show($id)
    {
        $subscription = Subscription::with(['payment', 'subscriptionPlan'])->findOrFail($id);

        return inertia('Subscriptions/Show', [
            'subscription' => $subscription,
            'payment' => $subscription->payment,
            'subscriptionPlan' => $subscription->subscriptionPlan,
        ]);
    }

    public function cancel($id)
    {
        $subscription = Subscription::findOrFail($id);

        $token = Crypt::decrypt($subscription->token);

        $login = config('gateway.services.placetopay.settings.login');
        $tranKey = config('gateway.services.placetopay.settings.tranKey');
        $seed = date('c');
        $rawNonce = Str::random();
        $nonce = base64_encode($rawNonce);
        $tranKeyEncoded = base64_encode(hash('sha256', $nonce . $seed . $tranKey, true));

        $auth = [
            'login' => $login,
            'tranKey' => $tranKeyEncoded,
            'nonce' => base64_encode($nonce),
            'seed' => $seed
        ];

        $data = [
            'auth' => $auth,
            'locale' => 'en_US',
            'instrument' => [
                'token' => [
                    'token' => $token,
                ],
            ],
        ];

        $response = Http::post(config('gateway.services.placetopay.settings.baseUrl') . 'api/instrument/invalidate', $data);

        dd($response->json()['status']['status']);
        if ($response->json()['status']['status'] == 'OK') {
            $subscription->status = PaymentStatus::CANCEL;
            $subscription->save();

            return response()->json(['message' => 'Subscription cancelled successfully.'], 200);
        }

        Log::error('Failed to cancel subscription', ['response' => $response->json()]);
        return response()->json(['error' => 'Failed to cancel subscription.'], 500);
    }
}
