<?php

namespace Tests\Feature\Microsites;

use App\Infrastructure\Persistence\Models\Category;
use App\Infrastructure\Persistence\Models\Microsite;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_index_microsite(): void
    {
        $user = User::factory()->create();
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
