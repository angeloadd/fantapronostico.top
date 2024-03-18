<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('bets', function (Blueprint $table): void {
            $table->id();
            $table->integer('home_result')->nullable();
            $table->integer('away_result')->nullable();
            $table->string('sign')->nullable();
            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')->references('id')->on('games');
            $table->string('created_at');
            $table->string('updated_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bets');
    }
};
