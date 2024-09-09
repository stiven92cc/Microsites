<?php

namespace Tests\Feature\Users;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_store_user(): void
    {
        $this->markTestSkipped();
        if (!Permission::where('name', Permissions::USERS_STORE)->exists()) {
            Permission::create(['name' => Permissions::USERS_STORE, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::USERS_STORE);

        $user = User::factory()->create();

        $user->assignRole($role);

        $data = [
            'name' => 'technology',
            'email' => 'prueba@gmail.com',
            'password' => 'description',

        ];

        $this->actingAs($user)
            ->post(route('users.store'), $data)
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'name' => 'technology',
            'email' => 'prueba@gmail.com',
            ]);
    }
}
