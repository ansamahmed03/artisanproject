<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artisan>
 */
class ArtisanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
'artisan_name'        => fake()->name(),
        'email'               => fake()->unique()->safeEmail(),
        'password'            => bcrypt('password'), 
        'store_name'          => fake()->company(),
        'bio'                 => fake()->paragraph(),
        'city'                => fake()->city(),
        'verification_status' => 'ON',
        'bank_info'           => fake()->iban('PS'),
        ];
    }
}
