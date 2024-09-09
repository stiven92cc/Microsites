<?php

namespace Tests\Feature\Categories;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\Category;
use App\Infrastructure\Persistence\Models\Microsite;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_edit_category(): void
    {
        if (!Permission::where('name', Permissions::CATEGORIES_EDIT)->exists()) {
            Permission::create(['name' => Permissions::CATEGORIES_EDIT, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::CATEGORIES_EDIT);

        $user = User::factory()->create();

        $user->assignRole($role);
        $categories = Category::factory()->create();


        $response = $this->actingAs($user)->get(route('categories.edit', $categories->id));

        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Categories/Edit')
            );
    }
}
