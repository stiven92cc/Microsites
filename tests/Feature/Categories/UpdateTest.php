<?php

namespace Tests\Feature\Categories;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\Category;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_category(): void
    {
        if (!Permission::where('name', Permissions::CATEGORIES_UPDATE)->exists()) {
            Permission::create(['name' => Permissions::CATEGORIES_UPDATE, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::CATEGORIES_UPDATE);

        $user = User::factory()->create();

        $user->assignRole($role);

        $category = Category::factory()->create();

        $data = [
            'name' => 'technology update',
            'alias' => 'technology',
            'description' => 'description'
        ];

        $this->actingAs($user)
            ->patch(route('categories.update', $category->id), $data)
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => $data['name'],
            'alias' => $data['alias'],
            'description' => $data['description'],
        ]);
    }
}
