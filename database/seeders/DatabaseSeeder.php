<?php

namespace Database\Seeders;

use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Location;
use App\Models\Product;
use App\Models\Report;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'admin@admin.dev',
        ]);

        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $stock = Stock::factory()->create(['product_id' => $product->id]);

        Location::factory()->create(['product_id' => $product->id]);
        Report::factory()->create([
            'product_id' => $product->id,
            'stock_id'   => $stock->id,
        ]);
    }
}
