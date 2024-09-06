<?php

namespace App\Http\Controllers\Subscription;

use App\Constants\SubscriptionPeriods;
use App\Http\Controllers\Controller;
use App\Infrastructure\Persistence\Models\SubscriptionPlan;
use App\Http\Requests\Subscriptions\StoreSubscriptionPlanRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SubscriptionPlanController extends Controller
{
    public function index(): Response
    {
        $subscriptionPlans = SubscriptionPlan::with('microsite')->get();
        return Inertia::render('Subscriptions/Index', [
            'subscriptionPlans' => $subscriptionPlans,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Subscriptions/Create', [
            'subscriptionPeriods' => SubscriptionPeriods::getAllSubscriptionPeriods()
        ]);
    }

    public function store(StoreSubscriptionPlanRequest $request, StoreSubscriptionPlanAction $action): RedirectResponse
    {
        SubscriptionPlan::create([
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount,
            'subscription_period' => $request->subscription_period,
            'expiration_time' => $request->expiration_time,
            'microsite_id' => $request->microsite_id,
        ]);

        return redirect()->route('subscription-plans.index')->with('success', 'Plan de suscripción creado exitosamente');
    }

    public function show(SubscriptionPlan $subscriptionPlan): Response
    {
        return Inertia::render('Subscription/Show', [
            'subscriptionPlan' => $subscriptionPlan->load('microsite'),
        ]);
    }

    public function edit(SubscriptionPlan $subscriptionPlan): Response
    {
        return Inertia::render('Subscription/Edit', [
            'subscriptionPlan' => $subscriptionPlan,
        ]);
    }

    public function update(StoreSubscriptionPlanRequest $request, SubscriptionPlan $subscriptionPlan): RedirectResponse
    {
        $subscriptionPlan->update($request->validated());

        return redirect()->route('subscription-plans.index')->with('success', 'Plan de suscripción actualizado exitosamente');
    }

    public function destroy(SubscriptionPlan $subscriptionPlan): RedirectResponse
    {
        $subscriptionPlan->delete();

        return redirect()->route('subscription-plans.index')->with('success', 'Plan de suscripción eliminado exitosamente');
    }
}
