<?php

namespace Tests\Feature\Microsites;

use App\Constants\CurrencyTypes;
use App\Constants\MicrositeTypes;
use App\Constants\Permissions;
use App\Infrastructure\Persistence\Models\User;
use App\Infrastructure\Persistence\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_microsite(): void
    {
        if (!Permission::where('name', Permissions::MICROSITES_CREATE)->exists()) {
            Permission::create(['name' => Permissions::MICROSITES_CREATE, 'guard_name' => 'web']);
        }

        $role = Role::findOrCreate('super_admin', 'web');
        $role->givePermissionTo(Permissions::MICROSITES_CREATE);

        $user = User::factory()->create();

        $user->assignRole($role);

        $response = $this->actingAs($user)
            ->get(route('microsites.create'));

        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Microsites/Create')
                    ->has('categories')
                    ->has('currencies')
                    ->has('types')
            );
    }
}
