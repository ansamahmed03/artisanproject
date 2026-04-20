<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Artisan;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        // بشكل عشوائي — review على Product أو Artisan
        $reviewable = $this->faker->randomElement([
            Product::inRandomOrder()->first(),
            Artisan::inRandomOrder()->first(),
        ]);

        return [
            'rating'          => $this->faker->numberBetween(1, 5),
            'comment'         => $this->faker->paragraph(),
            'reviewable_id'   => $reviewable->id,
            'reviewable_type' => get_class($reviewable),
            'customers_id'    => Customer::inRandomOrder()->first()?->id ?? Customer::factory(),
            'created_at'      => now(),
            'updated_at'      => now(),
        ];
    }
}