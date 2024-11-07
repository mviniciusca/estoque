<?php

namespace App\Models;

use App\Models\Stock;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $guarded = [];

    public function stock()
    {
        $this->belongsTo(Stock::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
