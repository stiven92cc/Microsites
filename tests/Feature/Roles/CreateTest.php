<?php

namespace Tests\Feature\Roles;

use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;


    public function test_can_create_rol(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->assertAuthenticatedAs($user)->get(route('roles.create'));
        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Roles/Create')
            );

    }
}
