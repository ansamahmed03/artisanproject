<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. نشغل فقط الـ Seeders اللي ما فيها مشاكل (تبعونك)
        // إذا كان الـ ProductSeeder تبعك ما بنادي حدا، خليه. إذا خايف منه، الغيه واستخدم الـ Factory هون

        // 2. تعبئة البيانات مباشرة باستخدام الـ Factories (أضمن حل لك)

        // إنشاء كاتيجوري (بدون مناداة السيدا تبعهم)
        \App\Models\Category::factory(5)->create();

        // إنشاء حرفيين (بدون مناداة السيدا تبعهم)
        \App\Models\Artisan::factory(10)->create()->each(function ($artisan) {
            $artisan->user()->create([
                'name' => $artisan->artisan_name,
                'email' => $artisan->email,
                'password' => bcrypt('password'),
            ]);
        });

        // 3. تعبئة بياناتك  (المنتجات والطلبات)
        \App\Models\Product::factory(30)->create();
        \App\Models\Customer::factory(10)->create();
        \App\Models\Order::factory(15)->create();
        \App\Models\OrderItem::factory(50)->create();
         \App\Models\Review::factory(40)->create();
    }
}
