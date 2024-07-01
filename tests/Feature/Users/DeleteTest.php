<?php

namespace Tests\Feature\Users;

use App\Infrastructure\Persistence\Models\Category;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_delete_user(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user)
            ->delete(route('users.destroy', $user2->id));


        $this->assertDatabaseMissing('users', ['id' => $user2->id]);
    }
}
