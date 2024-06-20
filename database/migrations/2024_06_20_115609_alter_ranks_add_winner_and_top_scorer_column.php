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
        Schema::table('ranks', static function (Blueprint $table): void {
            $table->boolean('winner')->default(false);
            $table->boolean('top_scorer')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ranks', static function (Blueprint $table): void {
            $table->dropColumn('winner');
            $table->dropColumn('top_scorer');
        });
    }
};
