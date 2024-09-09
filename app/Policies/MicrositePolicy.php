<?php

namespace App\Policies;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\Microsite;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Auth\Access\Response;

class MicrositePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::MICROSITES_INDEX);
    }


    public function create(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::MICROSITES_CREATE);
    }

    public function store(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::MICROSITES_STORE);
    }

    public function show(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::MICROSITES_SHOW);
    }

    public function edit(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::MICROSITES_EDIT);
    }


    public function update(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::MICROSITES_UPDATE);
    }


    public function delete(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::MICROSITES_DESTROY);
    }

}
