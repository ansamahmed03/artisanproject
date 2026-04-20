<?php

namespace Database\Factories;

use App\Models\Wishlist;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class WishlistFactory extends Factory
{
    protected $model = Wishlist::class;

    public function definition(): array
    {
        return [
            'customer_id' => Customer::inRandomOrder()->first()?->id ?? Customer::factory(),
            'product_id'  => Product::inRandomOrder()->first()?->id  ?? Product::factory(),
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
