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
        Schema::create('departments', function (Blueprint $table) {
            $table->id(); // Khóa chính, tự động tăng
            $table->string('name')->unique(); // Tên phòng ban, duy nhất
            $table->string('slug')->unique(); // Slug phòng ban, duy nhất
            $table->text('description')->nullable(); // Mô tả phòng ban, có thể null
            $table->timestamps(); // created_at và updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
};
