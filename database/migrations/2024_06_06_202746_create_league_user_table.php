<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('league_user', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('league_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->enum('status', ['pending', 'accepted']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_user');
    }
};
