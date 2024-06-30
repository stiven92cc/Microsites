<?php

namespace App\Domain\Roles;

use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class UpdateRolesAction

{
    public function execute(int $id, array $data): RedirectResponse
    {
        $role = Role::findOrFail($id);

        $role->update([
            'name' => $data['name'],
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($data['permissions'] ?? []);

        return to_route('roles.index');
    }
}
