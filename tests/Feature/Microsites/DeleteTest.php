<?php

namespace Tests\Feature\Microsites;

use App\Infrastructure\Persistence\Models\Microsite;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_delete_microsite(): void
    {
        $user = User::factory()->create();

        $microsite = Microsite::factory()->create();

        $this->actingAs($user)
            ->delete(route('microsites.destroy', $microsite->id))
            ->assertRedirect(route('microsites.index'));

        $this->assertDatabaseMissing('microsites', ['id' => $microsite->id]);

    }
}
