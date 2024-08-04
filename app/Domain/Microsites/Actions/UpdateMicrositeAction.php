<?php

namespace App\Domain\Microsites\Actions;

use App\Infrastructure\Persistence\Models\Microsite;
use Illuminate\Support\Facades\Storage;

class UpdateMicrositeAction
{
    public function execute(array $data, int $id): void
    {
        $microsite = Microsite::findOrFail($id);

        if (isset($data['logo']) && $data['logo']) {
            if ($microsite->logo) {
                Storage::disk('public')->delete($microsite->logo);
            }

            $data['logo'] = $data['logo']->store('logo', ['disk' => 'public']);
        } else {
        unset($data['logo']);
    }

        $microsite->update($data);
    }
}
