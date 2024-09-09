<?php

namespace Tests\Feature\Categories;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\Category;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_index_category(): void
    {
        if (!Permission::where('name', Permissions::CATEGORIES_INDEX)->exists()) {
            Permission::create(['name' => Permissions::CATEGORIES_INDEX, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::CATEGORIES_INDEX);

        $user = User::factory()->create();

        $user->assignRole($role);
        Category::factory()->create();

        $response = $this->actingAs($user)->get(route('categories.index'));

        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Categories/Index')
                    ->has('categories')
            );
    }
}
