<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artisans', function (Blueprint $table) {
            $table->id();
            $table->string('artisan_name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('store_name');
            $table->text('bio');
            $table->string('city');
            $table->enum('verification_status',['ON' , 'OFF'])->default('ON');
            $table->string('bank_info');






            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artisans');
    }
};
