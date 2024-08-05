<?php

namespace Tests\Feature\Roles;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_destroy_role(): void
    {
        if (!Permission::where('name', Permissions::ROLES_DESTROY)->exists()) {
            Permission::create(['name' => Permissions::ROLES_DESTROY, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::ROLES_DESTROY);

        $user = User::factory()->create();

        $user->assignRole($role);

        $role = Role::findOrCreate('super_admin', 'web');

        $response = $this->actingAs($user)
            ->delete(route('roles.destroy', $role->id));

        $response->assertRedirect(route('roles.index'));

    }
}
