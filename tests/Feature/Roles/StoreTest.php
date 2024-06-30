<?php

namespace Tests\Feature\Roles;

use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StoreTest extends TestCase
{
    Use RefreshDatabase;

    protected array $request;

    public function setUp(): void
    {
      parent::setUp();

      Permission::findOrCreate('microsites.index', 'web');

      $this->request=[
          'name' => 'Admin',
          'permissions' => 'microsites.index',
      ];
    }

    public function test_can_store_rol(): void
    {
        $user = User::factory()->create();

        $role = Role::findOrCreate('super_admin', 'web');

        $user->assignRole($role);

        $permissionIndex = Permission::findOrCreate('microsites.index', 'web');
        $permissionStore = Permission::findOrCreate('microsites.store', 'web');

        $user->givePermissionTo($permissionIndex, $permissionStore);


        $response = $this->actingAs($user)
            ->post(route('roles.store'),$this->request);

        $response->assertRedirect(route('roles.index'));

    }
}
