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
   
    Schema::table('admins', function (Blueprint $table) {
        $table->softDeletes();
    });


    Schema::table('artisans', function (Blueprint $table) {
        $table->softDeletes();
    });
}

public function down()
{
    Schema::table('admins', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });

    Schema::table('artisans', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });
    }
};
