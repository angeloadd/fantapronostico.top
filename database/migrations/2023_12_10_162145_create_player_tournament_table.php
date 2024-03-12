<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    private const TABLE_NAME = 'player_tournament';

    public function up(): void
    {
        Schema::create(
            self::TABLE_NAME,
            static function (Blueprint $table): void {
                $table->id();
                $table->foreignId('player_id')
                    ->constrained()
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
                $table->foreignId('tournament_id')
                    ->constrained()
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
                $table->boolean('is_top_scorer')
                    ->default(false);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
