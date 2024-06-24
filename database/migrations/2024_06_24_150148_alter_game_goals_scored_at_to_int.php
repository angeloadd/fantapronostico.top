<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('game_goals', function (Blueprint $table) {
            $table->dropColumn('scored_at');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
        Schema::table('game_goals', function (Blueprint $table) {
            $table->integer('scored_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_goals', function (Blueprint $table) {
            $table->dropColumn('scored_at');
        });
        Schema::table('game_goals', function (Blueprint $table) {
            $table->timestamp('scored_at')->nullable();
            $table->timestamps();
        });
    }
};
