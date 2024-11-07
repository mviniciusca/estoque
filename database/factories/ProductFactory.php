<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'stock_id'    => Stock::factory(),
            'price'       => $this->faker->numberBetween(100, 10000) / 100,
            'name'        => $this->faker->company(),
            'sku'         => $this->faker->unique()->numerify('####'),
        ];
    }
}
