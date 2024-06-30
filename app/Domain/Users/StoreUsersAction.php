<?php

namespace App\Domain\Users;

use App\Http\Requests\Microsites\StoreMicrositeRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Infrastructure\Persistence\Models\Microsite;
use App\Infrastructure\Persistence\Models\User;

class StoreUsersAction
{
    public function execute(StoreUserRequest $request): void
    {
        $user = User::query()->create($request->validated());
        $user->assignRole($request->get('role'));
    }
}
