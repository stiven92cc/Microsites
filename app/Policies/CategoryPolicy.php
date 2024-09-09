<?php

namespace App\Policies;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::CATEGORIES_INDEX);
    }


    public function create(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::CATEGORIES_CREATE);
    }

    public function store(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::CATEGORIES_STORE);
    }

    public function edit(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::CATEGORIES_EDIT);
    }


    public function update(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::CATEGORIES_UPDATE);
    }


    public function delete(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::CATEGORIES_DESTROY);
    }
}
