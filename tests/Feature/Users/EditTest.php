<?php

namespace Tests\Feature\Users;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_edit_user(): void
    {
        if (!Permission::where('name', Permissions::USERS_EDIT)->exists()) {
            Permission::create(['name' => Permissions::USERS_EDIT, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::USERS_EDIT);

        $user = User::factory()->create();

        $user->assignRole($role);

        $response = $this->actingAs($user)->assertAuthenticatedAs($user)->get(route('users.edit', $user->id));

        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Users/Edit')
            );
    }
}
