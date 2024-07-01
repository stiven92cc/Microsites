<?php

namespace Tests\Feature\Roles;

use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_edit_rol(): void
    {
        $user = User::factory()->create();
        $role = Role::findOrCreate('super_admin', 'web');

        $response = $this->actingAs($user)->assertAuthenticatedAs($user)->get(route('roles.edit', $role->id));

        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Roles/Edit')
            );
    }
}
