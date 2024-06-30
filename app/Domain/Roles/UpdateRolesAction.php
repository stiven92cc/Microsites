<?php

namespace App\Domain\Roles;

use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class UpdateRolesAction

{
    public function execute(int $id, array $data): RedirectResponse
    {
        $role = Role::find($id);

        $role->update($data);

        return to_route('roles.index');
    }
}
