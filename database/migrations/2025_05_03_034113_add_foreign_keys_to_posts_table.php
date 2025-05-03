<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Đảm bảo các cột đã tồn tại trước
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->nullOnDelete(); // Laravel 12 khuyến khích dùng nullOnDelete()

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['tag_id']);
            $table->dropForeign(['category_id']);
        });
    }
};
