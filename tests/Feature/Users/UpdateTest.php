<?php

namespace Tests\Feature\Users;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_user(): void
    {
        if (!Permission::where('name', Permissions::USERS_UPDATE)->exists()) {
            Permission::create(['name' => Permissions::USERS_UPDATE, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::USERS_UPDATE);

        $user = User::factory()->create();

        $user->assignRole($role);

        $data = [
            'name' => 'technology',
            'email' => 'prueba@gmail.com',
            'password' => '123456789'
        ];

        $this->actingAs($user)
            ->patch(route('users.update', $user->id), $data)
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }
}
