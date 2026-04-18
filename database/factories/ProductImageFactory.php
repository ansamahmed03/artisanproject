<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
{
    return [
        'product_id' => Product::inRandomOrder()->first()?->id ?? Product::factory(),
        'image_path' => 'product-images/' . $this->faker->uuid() . '.jpg',
        'is_primary'  => $this->faker->boolean(25),
        'created_at'  => now(),
        'updated_at'  => now(),
    ];
}
}
