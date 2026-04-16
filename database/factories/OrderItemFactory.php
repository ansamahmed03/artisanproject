<?php

namespace Database\Factories;

use App\Models\Order_Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order_Item>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
       'order_id'   => \App\Models\Order::inRandomOrder()->first()->id,
       'product_id' => \App\Models\Product::inRandomOrder()->first()->id,
       'quantity'   => fake()->numberBetween(1, 5),
       'price'      => function (array $attributes) {
        return \App\Models\Product::find($attributes['product_id'])->price;
    },
];
    }
}
