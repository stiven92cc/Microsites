<?php

namespace App\Http\Controllers\Subscription;

use App\Constants\SubscriptionPeriods;
use App\Domain\Subscriptions\StoreSubscriptionsPlanAction;
use App\Http\Controllers\Controller;
use App\Infrastructure\Persistence\Models\SubscriptionPlan;
use App\Http\Requests\Subscriptions\StoreSubscriptionPlanRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function create($id): Response
    {
        return Inertia::render('Subscriptions/Create', [
            'subscriptionPeriods' => SubscriptionPeriods::getAllSubscriptionPeriods(),
            'microsite_id' => $id
        ]);
    }

    public function store(StoreSubscriptionPlanRequest $request, StoreSubscriptionsPlanAction $action): RedirectResponse
    {
        $action->execute($request->validated());

        return redirect()->route('microsites.index');
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
