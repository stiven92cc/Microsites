<?php

namespace Tests\Feature\Users;

use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_user(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'technology',
            'email' => 'prueba@gmail.com',
            'password' => '123456789'
        ];

        $this->actingAs($user)
            ->patch(route('users.update', $user->id), $data)
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }
}
