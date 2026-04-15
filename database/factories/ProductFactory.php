<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Artisan;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array

            //public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true), // يولد اسم منتج من 3 كلمات
            'description' => $this->faker->paragraph(), // وصف طويل
            'price' => $this->faker->randomFloat(2, 10, 500), // سعر عشوائي بين 10 و 500
            'stock_quantity' => $this->faker->numberBetween(1, 100), // كمية بين 1 و 100

            // هنا نربط المنتج بـ Category و Artisan موجودين فعلياً
            'category_id' => Category::all()->random()->id,
            'artisan_id' => Artisan::all()->random()->id,

            'status' => $this->faker->randomElement(['available', 'out_of_stock', 'pending']),
        ];
    }


}
