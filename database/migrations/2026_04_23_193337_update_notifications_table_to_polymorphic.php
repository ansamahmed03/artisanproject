<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // شيل الـ users_id
            $table->dropForeign(['users_id']);
            $table->dropColumn('users_id');

            // أضف polymorphic
            $table->unsignedBigInteger('notifiable_id')->after('is_read');
            $table->string('notifiable_type')->after('notifiable_id');
            $table->index(['notifiable_id', 'notifiable_type']);
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['notifiable_id', 'notifiable_type']);
            $table->dropColumn(['notifiable_id', 'notifiable_type']);
            $table->foreignId('users_id')->constrained('users')->cascadeOnDelete();
        });
    }
};
