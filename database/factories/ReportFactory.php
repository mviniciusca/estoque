<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_dispatch' => $this->faker->boolean(),
            'minimus'     => $this->faker->numberBetween(3, 10),
            'product_id'  => Product::factory(),
            'stock_id'    => Stock::factory(),
        ];
    }
}
