<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('order_items', function (Blueprint $table) {
        // احذف الـ foreign key القديم
        $table->dropForeign(['order_id']);

        // أضفيه من جديد بدون cascade
        $table->foreign('order_id')
              ->references('id')
              ->on('orders')
              ->nullOnDelete(); // أو restrictOnDelete()
    });
}

public function down()
{
    Schema::table('order_items', function (Blueprint $table) {
        $table->dropForeign(['order_id']);
        $table->foreign('order_id')
              ->references('id')
              ->on('orders')
              ->cascadeOnDelete();
    });
}
};
