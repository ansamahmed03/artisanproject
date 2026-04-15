<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();

        // السعر يفضل أن يكون decimal للحسابات الدقيقة (10 خانات، 2 منها بعد الفاصلة)
        $table->decimal('price', 10, 2);

        $table->integer('stock_quantity')->default(0); // الكمية

        // Category
        $table->foreignId('category_id');
        $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();


        //  Artisan
        $table->foreignId('artisan_id');
        $table->foreign('artisan_id')->references('id')->on('artisans')->cascadeOnDelete();

        // حالة  (مثلاً: active, inactive, pending)
        $table->enum('status', ['available', 'out_of_stock', 'pending'])->default('available');

        $table->timestamps();
        $table->softDeletes(); //  الحذف
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
