<?php

namespace App\Domain\Roles;

use Spatie\Permission\Models\Role;

class StoreRolesAction
{
    public function execute (array $roles)
    {
        Role::create([
           'name'=>$roles['name'],
           'ward_name'=>'web'
        ]);

        return to_route('roles.index');
    }
}
