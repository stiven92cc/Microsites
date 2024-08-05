<?php

namespace Tests\Feature\Users;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_index_user(): void
    {
        if (!Permission::where('name', Permissions::USERS_INDEX)->exists()) {
            Permission::create(['name' => Permissions::USERS_INDEX, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::USERS_INDEX);

        $user = User::factory()->create();

        $user->assignRole($role);

        $response = $this->actingAs($user)->assertAuthenticatedAs($user)->get(route('users.index'));

        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Users/Index')
                    ->has('users')
            );

    }
}
