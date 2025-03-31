<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('season_guild_top10', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('season_id');
            $table->string('guild_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedTinyInteger('rank');
            $table->integer('score');
            $table->unsignedBigInteger('sun_time')->nullable();
            $table->timestamps();

            $table->foreign('season_id')->references('id')->on('season_histories')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('season_guild_top10');
    }
};
