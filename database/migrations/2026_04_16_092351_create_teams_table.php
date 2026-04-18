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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('team_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->text('bio')->nullable();
            $table->decimal('hourly_rate', 8, 2); // عشان يكون رقم عشري للسعر
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->enum('status', ['active', 'closed', 'busy'])->default('active');
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
