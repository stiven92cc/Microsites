<?php

namespace Tests\Feature\Categories;

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

    public function test_can_create_category(): void
    {
        if (!Permission::where('name', Permissions::CATEGORIES_CREATE)->exists()) {
            Permission::create(['name' => Permissions::CATEGORIES_CREATE, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::CATEGORIES_CREATE);

        $user = User::factory()->create();

        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->get(route('categories.create'));

        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Categories/Create')
            );
    }
}
