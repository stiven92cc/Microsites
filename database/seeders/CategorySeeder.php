<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = [
            [
                'name' => 'invoice',
                'alias' => 'invoice',
                'description' => 'description invoice',
            ],
            [
                'name' => 'subscription',
                'alias' => 'subscription',
                'description' => 'description subscription',
            ],
            [
                'name' => 'donation',
                'alias' => 'donation',
                'description' => 'description donation',
            ],
        ];
        Category::query()->insert($category);
    }
}
