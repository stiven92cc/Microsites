<?php

namespace App\Domain\Microsites\Actions;

use App\Domain\Forms\CreateFormConfiguration;
use App\Infrastructure\Persistence\Models\Form;
use App\Infrastructure\Persistence\Models\Microsite;

class StoreMicrositeAction
{
    public function execute(array $data): void
    {
        $createFormConfiguration = new CreateFormConfiguration();

        if (isset($data['logo']) && is_file($data['logo'])) {
            $data['logo'] = $data['logo']->store('logo', ['disk' => 'public']);
        }

        $formConfiguration = $createFormConfiguration->create($data['type']);

        $form = Form::create([
            'form_configuration' => json_encode($formConfiguration)
        ]);

        Microsite::query()->create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'logo' => $data['logo'],
            'category_id' => $data['category_id'],
            'type' => $data['type'],
            'currency' => $data['currency'],
            'payment_expiration' => $data['payment_expiration'],
            'form_id' => $form->id,
        ]);
    }
}
