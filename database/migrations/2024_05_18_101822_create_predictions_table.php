<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public const TABLE_NAME = 'predictions';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            self::TABLE_NAME,
            static function (Blueprint $table): void {
                $table->id();
                $table->foreignId('user_id')->constrained();
                $table->foreignId('game_id')->constrained();
                $table->integer('home_score');
                $table->integer('away_score');
                $table->enum('sign', ['1', 'x', '2']);
                $table->foreignId('home_scorer_id')->nullable()->constrained('players');
                $table->boolean('is_home_own');
                $table->foreignId('away_scorer_id')->nullable()->constrained('players');
                $table->foreignId('is_away_own')->nullable()->constrained('players');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
