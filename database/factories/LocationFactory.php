<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'section' => Str::upper($this->faker->randomLetter()) .  $this->faker->randomDigit(),
            'geocode' => $this->faker->numerify('-######') . ' ' . $this->faker->numerify('######'),
            'product_id' => Product::factory(),
        ];
    }
}
