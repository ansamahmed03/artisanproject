<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

public function run(): void
{
    \App\Models\Category::factory(20)->create();

    \App\Models\Artisan::factory(20)->create();

    // كل منتج إله صورة primary واحدة
    Product::factory(30)->create()->each(function ($product) {
     ProductImage::factory()->create([
            'product_id' => $product->id,
            'is_primary' => 1
        ]);
    });

   // \App\Models\Customer::factory(10)->create();
    \App\Models\Order::factory(15)->create();
    \App\Models\OrderItem::factory(50)->create();
}
}