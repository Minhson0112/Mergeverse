<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('guild_player', function (Blueprint $table) {
            $table->id(); // BIGINT
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->unsignedBigInteger('guild_id');
            $table->timestamp('last_played_at')->nullable();
            $table->timestamps();

            $table->unique(['player_id', 'guild_id']); // Tránh trùng
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guild_player');
    }
};
