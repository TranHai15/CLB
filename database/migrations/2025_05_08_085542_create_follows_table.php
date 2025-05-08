<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();

            // Người theo dõi
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Người được theo dõi
            $table->foreignId('target_user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['user_id', 'target_user_id']); // không cho theo dõi trùng
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
