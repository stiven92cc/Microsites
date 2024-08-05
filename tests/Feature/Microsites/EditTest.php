<?php

namespace Tests\Feature\Microsites;

use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use App\Infrastructure\Persistence\Models\Microsite;
use App\Infrastructure\Persistence\Models\Category;
use Inertia\Testing\AssertableInertia as Assert;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_edit_microsite(): void
    {
        if (!Permission::where('name', Permissions::MICROSITES_EDIT)->exists()) {
            Permission::create(['name' => Permissions::MICROSITES_EDIT, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::MICROSITES_EDIT);

        $user = User::factory()->create();

        $user->assignRole($role);
        $category = Category::factory()->create();
        $microsite = Microsite::factory()->create([
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)->get(route('microsites.edit', $microsite->id));

        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Microsites/Edit')
                    ->has('categories')
                    ->has('currencies')
                    ->has('types')
                    ->has('microsite')
            );
    }
}
