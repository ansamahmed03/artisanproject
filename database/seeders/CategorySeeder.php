<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // إضافة 5 أصناف وهمية بأسماء عشوائية
 \App\Models\Category::factory(10)->create();
    }
}
