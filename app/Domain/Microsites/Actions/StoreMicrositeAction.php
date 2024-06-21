<?php

namespace App\Domain\Microsites\Actions;

use App\Http\Requests\Microsites\StoreMicrositeRequest;
use App\Infrastructure\Persistence\Models\Category;
use App\Infrastructure\Persistence\Models\Microsite;
use Illuminate\Support\Str;

class StoreMicrositeAction
{
    public function execute(StoreMicrositeRequest $request)
    {
        dd($request);
        $category = Category::find();

       Microsite::query()->create([
           'name' => $request['name'],
           'slug' => $request['name'] . '_' . Str::random(50, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'),
           'currency'=> $request['currency'],
           'payment_expiration' => $request['payment_expiration'],
           'category_id'
       ]);
    }
}
