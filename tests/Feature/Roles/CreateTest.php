<?php

namespace Tests\Feature\Roles;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;


    public function test_can_create_rol(): void
    {
        if (!Permission::where('name', Permissions::ROLES_CREATE)->exists()) {
            Permission::create(['name' => Permissions::ROLES_CREATE, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::ROLES_CREATE);

        $user = User::factory()->create();

        $user->assignRole($role);

        $response = $this->actingAs($user)->assertAuthenticatedAs($user)->get(route('roles.create'));
        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Roles/Create')
            );

    }
}
