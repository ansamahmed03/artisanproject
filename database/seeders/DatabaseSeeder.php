<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;

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

        // إنشاء حرفيين (بدون مناداة السيدا تبعهم)
        \App\Models\Artisan::factory(10)->create()->each(function ($artisan) {
            $artisan->user()->create([
                'name' => $artisan->artisan_name,
                'email' => $artisan->email,
                'password' => bcrypt('password'),
            ]);
        });

        // 3. تعبئة بياناتك  (المنتجات والطلبات)
        \App\Models\Product::factory(30)->create();
        \App\Models\Customer::factory(10)->create();
        \App\Models\Order::factory(15)->create();
        \App\Models\OrderItem::factory(50)->create();
         \App\Models\Review::factory(40)->create();
    }
   // \App\Models\Customer::factory(10)->create();



}
