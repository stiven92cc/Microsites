<?php

namespace Tests\Feature\Users;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\Category;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_delete_user(): void
    {
        if (!Permission::where('name', Permissions::USERS_DESTROY)->exists()) {
            Permission::create(['name' => Permissions::USERS_DESTROY, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::USERS_DESTROY);

        $user = User::factory()->create();

        $user->assignRole($role);
        $user2 = User::factory()->create();

        $this->actingAs($user)
            ->delete(route('users.destroy', $user2->id));


        $this->assertDatabaseMissing('users', ['id' => $user2->id]);
    }
}
