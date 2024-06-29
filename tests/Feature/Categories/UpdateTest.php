<?php

namespace Tests\Feature\Categories;

use App\Infrastructure\Persistence\Models\Category;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_category(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create();

        $data = [
            'name' => 'technology update',
            'alias' => 'technology',
            'description' => 'description'
        ];

        $this->actingAs($user)
            ->patch(route('categories.update', $category->id), $data)
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => $data['name'],
            'alias' => $data['alias'],
            'description' => $data['description'],
        ]);
    }
}
