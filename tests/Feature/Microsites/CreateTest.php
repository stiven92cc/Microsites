<?php

namespace Tests\Feature\Microsites;

use App\Constants\CurrencyTypes;
use App\Constants\MicrositeTypes;
use App\Infrastructure\Persistence\Models\User;
use App\Infrastructure\Persistence\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_microsite(): void
    {
        $user = User::factory()->create();

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
