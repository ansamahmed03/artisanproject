<?php

namespace Database\Seeders;

use App\Models\Artisan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtisanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Artisan::factory(30)->create();
    }
}
