<?php

namespace Database\Factories;

use App\Infrastructure\Persistence\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'alias' => $this->faker->name(),
            'description' => $this->faker->name(),
        ];
    }
}
