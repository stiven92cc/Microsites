<?php

namespace Tests\Feature\Users;

use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_store_user(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'technology',
            'email' => 'prueba@gmail.com',
            'password' => 'description',

        ];

        $this->actingAs($user)
            ->post(route('users.store'), $data)
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'name' => 'technology',
            'email' => 'prueba@gmail.com',
            ]);
    }
}
