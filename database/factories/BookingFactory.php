<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'booking_date' => $this->faker->dateTimeBetween('now', '+3 months')->format('Y-m-d'),
            'status'       => $this->faker->randomElement(['pending', 'confirmed', 'completed', 'cancelled']),
            'notes'        => $this->faker->optional()->sentence(),
            'customer_id'  => Customer::inRandomOrder()->first()?->id ?? Customer::factory(),
            'team_id'      => Team::inRandomOrder()->first()?->id   ?? Team::factory(),
            'created_at'   => now(),
            'updated_at'   => now(),
        ];
    }
}
