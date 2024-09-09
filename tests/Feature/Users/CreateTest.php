<?php

namespace Tests\Feature\Users;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_index_user(): void
    {
        if (!Permission::where('name', Permissions::USERS_CREATE)->exists()) {
            Permission::create(['name' => Permissions::USERS_CREATE, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::USERS_CREATE);

        $user = User::factory()->create();

        $user->assignRole($role);

        $response = $this->actingAs($user)->assertAuthenticatedAs($user)->get(route('users.create'));

        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Users/Create')
            );

    }
}
