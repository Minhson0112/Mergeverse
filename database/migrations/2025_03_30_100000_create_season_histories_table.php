<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('season_histories', function (Blueprint $table) {
            $table->id(); // dùng làm số mùa
            $table->timestamp('start_at');
            $table->timestamp('end_at')->nullable(); // set khi reset xong
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('season_histories');
    }
};
