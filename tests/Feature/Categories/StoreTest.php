<?php

namespace Tests\Feature\Categories;

use App\Constants\MicrositeTypes;
use App\Infrastructure\Persistence\Models\Category;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_store_category(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'technology',
            'description' => 'technology',
            'alias' => 'description',

        ];

        $this->actingAs($user)
            ->post(route('categories.store'), $data)
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', $data);
    }

    public function test_can_not_store_categories_if_is_not_authenticated(): void
    {
        $data = [
            'name' => 'technology',
            'description' => 'technology',
            'alias' => 'description',
        ];

        $this->post(route('categories.store'), $data)
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('categories', [
            'name' => 'technology',
            'description' => 'technology',
            'alias' => 'description'
            ]);
    }
}
