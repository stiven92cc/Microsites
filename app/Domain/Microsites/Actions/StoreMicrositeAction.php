<?php

namespace App\Domain\Microsites\Actions;

use App\Http\Requests\Microsites\StoreMicrositeRequest;
use App\Infrastructure\Persistence\Models\Category;
use App\Infrastructure\Persistence\Models\Microsite;
use Illuminate\Support\Str;

class StoreMicrositeAction
{
    public function execute(StoreMicrositeRequest $request): void
    {
        $data = $request->toArray();

        if (isset($data['logo'])) {
            $data['logo'] = $data['logo']->store('logo', ['disk' => 'public']);
        }
        Microsite::query()->create($data);
    }
}
