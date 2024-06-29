<?php

namespace Tests\Feature\Microsites;

use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;
use App\Infrastructure\Persistence\Models\Microsite;
use App\Infrastructure\Persistence\Models\Category;
use Inertia\Testing\AssertableInertia as Assert;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_edit_microsite(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $microsite = Microsite::factory()->create([
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)->get(route('microsites.edit', $microsite->id));

        $response->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Microsites/Edit')
                    ->has('categories')
                    ->has('currencies')
                    ->has('types')
                    ->has('microsite')
            );
    }
}
