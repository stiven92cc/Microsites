<?php

namespace Tests\Feature\Microsites;

use App\Constants\MicrositeTypes;
use App\Infrastructure\Persistence\Models\Category;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_store_a_microsite(): void
    {
        $user = User::factory()->create();

        Storage::fake('public');
        $file = UploadedFile::fake()->image('logo.jpg');

        $data = [
            'name' => 'technology',
            'slug' => 'technology',
            'category_id' => Category::factory()->create()->id,
            'type' => MicrositeTypes::DONATION,
            'currency' => 'COP',
            'payment_expiration' => 12,
            'logo' => $file,
        ];

        $this->actingAs($user)
            ->post(route('microsites.store'), $data)
            ->assertRedirect(route('microsites.index'));

        $this->assertDatabaseHas('microsites', $data);
    }

    public function test_can_not_store_microsite_if_is_not_authenticated(): void
    {
        $data = [
            'name' => 'technology',
            'slug' => 'technology',
            'logo' => 'description',
            'category_id' => Category::factory()->create()->id,
            'type' => MicrositeTypes::DONATION,
            'currency' => 'COP',
            'payment_expiration' => 12
        ];

        $this->post(route('microsites.store'), $data)
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('microsites', [
            'name' => 'technology',
            'slug' => 'technology',
            'logo' => 'description',
            'category_id' => Category::factory()->create()->id,
            'type' => MicrositeTypes::DONATION,
            'currency' => 'COP',
            'payment_expiration' => 12
        ]);
    }
}
