<?php

namespace App\Domain\Roles;

use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class StoreRolesAction
{
    public function execute(array $data): RedirectResponse
    {

        Role::create([
            'name' => $data['name'],
            'guard_name' => 'web',
        ])->syncPermissions($data['permissions'] ?? []);

        return to_route('roles.index');
    }
}
