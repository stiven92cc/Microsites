<?php

namespace App\Domain\Subscriptions;

use App\Constants\SubscriptionPeriods;
use App\Infrastructure\Persistence\Models\SubscriptionPlan;

class StoreSubscriptionsPlanAction
{
    public function execute(array $data): void
    {

        if (!in_array($data['subscription_period'], SubscriptionPeriods::getAllSubscriptionPeriods())) {
            throw new \InvalidArgumentException('El período de suscripción es inválido.');
        }

        if (isset($data['descriptions']) && !is_array($data['descriptions'])) {
            throw new \InvalidArgumentException('La descripción debe ser un array.');
        }

        SubscriptionPlan::create([
            'name' => $data['name'],
            'description' => json_encode($data['descriptions']),
            'amount' => $data['amount'],
            'subscription_period' => $data['subscription_period'],
            'expiration_time' => $data['expiration_time'],
            'microsite_id' => $data['microsite_id'],
        ]);
    }
}
