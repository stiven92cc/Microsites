<?php

namespace Tests\Feature\Roles;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        if (!Permission::where('name', 'microsites.index')->exists()) {
            Permission::create(['name' => 'microsites.index', 'guard_name' => 'web']);
        }

        if (!Permission::where('name', Permissions::ROLES_CREATE)->exists()) {
            Permission::create(['name' => Permissions::ROLES_CREATE, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo('microsites.index');

        $this->request = [
            'name' => 'updated-role',
            'guard_name' => 'web',
            'permissions' => [
                [
                    'name' => Permissions::ROLES_CREATE,
                ],
            ],
        ];
    }

    public function test_can_update_role(): void
    {
        $user = User::factory()->create();

        $role = Role::findByName('super_admin', 'web');

        $response = $this->actingAs($user)
            ->assertAuthenticatedAs($user)
            ->put(route('roles.update', $role->id), $this->request);

        $response->assertRedirect(route('roles.index'));
    }
}
