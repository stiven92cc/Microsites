<?php

namespace Database\Seeders;

use App\Constants\Permissions;
use Spatie\Permission\Models\Role;
use App\Constants\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    protected array $roles = [
        ['name' => Roles::ADMIN, 'guard_name' => 'web'],
        ['name' => Roles::GUEST, 'guard_name' => 'web']
    ];

    public function run(): void
    {
        DB::table('roles')->upsert($this->roles, 'name');

        $this->assignPermissionsToAdmin();
        $this->assignPermissionsToGuest();
    }

    private function assignPermissionsToAdmin(): void
    {
        $admin = Role::findByName(Roles::ADMIN);
        $admin->syncPermissions(Permissions::getAllPermissions());
    }

    private function assignPermissionsToGuest(): void
    {
        $admin = Role::findByName(Roles::GUEST);
        $admin->syncPermissions(Permissions::getGuestPermissions());
    }
}
