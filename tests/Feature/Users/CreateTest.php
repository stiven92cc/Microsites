<?php

namespace Tests\Feature\Users;

use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_index_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->assertAuthenticatedAs($user)->get(route('users.create'));

        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Users/Create')
            );

    }
}
