<?php

namespace Database\Factories;

use App\Constants\CurrencyTypes;
use App\Constants\MicrositeTypes;
use App\Infrastructure\Persistence\Models\Category;
use App\Infrastructure\Persistence\Models\Microsite;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Category>
 */
class MicrositeFactory extends Factory
{
    protected $model = Microsite::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->name(),
            'logo' => $this->faker->name(),
            'category_id' => Category::factory()->create()->id,
            'type' => $this->faker->randomElement(MicrositeTypes::getTypes()),
            'currency' => $this->faker->randomElement(CurrencyTypes::getTypes()),
            'payment_expiration' => $this->faker->numberBetween(3, 100),
        ];
    }
}
