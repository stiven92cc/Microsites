<?php

namespace Tests\Feature\Microsites;

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

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_index_microsite(): void
    {
        if (!Permission::where('name', Permissions::MICROSITES_INDEX)->exists()) {
            Permission::create(['name' => Permissions::MICROSITES_INDEX, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::MICROSITES_INDEX);

        $user = User::factory()->create();

        $user->assignRole($role);
        Microsite::factory()->create();

        $response = $this->actingAs($user)->get(route('microsites.index'));

        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Microsites/Index')
                    ->has('microsites')
            );
    }
}
