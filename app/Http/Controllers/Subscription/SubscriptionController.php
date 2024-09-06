<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use App\Infrastructure\Persistence\Models\Microsite;
use App\Infrastructure\Persistence\Models\Subscription;
use Inertia\Inertia;
use Inertia\Response;

class SubscriptionController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Subscriptions/Index', ['subscriptions' => Subscription::all()]);
    }

    public function show(Subscription $subscription): Response
    {
        return Inertia::render('Subscriptions/Show', [
            'subscription' => $subscription->load(['category', 'form']),
        ]);
    }


}
