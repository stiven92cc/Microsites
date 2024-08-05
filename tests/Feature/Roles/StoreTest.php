<?php

namespace Tests\Feature\Roles;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    protected array $request;

    public function setUp(): void
    {
        parent::setUp();

        Permission::findOrCreate('microsites.index', 'web');

        $this->request = [
            'name' => 'updated-role',
            'guard_name' => 'web',
            'permissions' => [
                [
                    'name' => Permissions::CATEGORIES_INDEX,
                ],
            ],
        ];
    }

    public function test_can_store_rol(): void
    {
        Permission::create(['name' => Permissions::CATEGORIES_INDEX, 'guard_name' => 'web']);
        if (!Permission::where('name', Permissions::ROLES_STORE)->exists()) {
            Permission::create(['name' => Permissions::ROLES_STORE, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::ROLES_STORE);

        $user = User::factory()->create();

        $user->assignRole($role);

        $role = Role::findOrCreate('super_admin', 'web');

        $user->assignRole($role);

        $permissionIndex = Permission::findOrCreate('microsites.index', 'web');
        $permissionStore = Permission::findOrCreate('microsites.store', 'web');

        $user->givePermissionTo($permissionIndex, $permissionStore);


        $response = $this->actingAs($user)
            ->post(route('roles.store'), $this->request);

        $response->assertRedirect(route('roles.index'));

    }
}
