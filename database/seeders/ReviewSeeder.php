<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Review::factory(40)->create();
    }
}
