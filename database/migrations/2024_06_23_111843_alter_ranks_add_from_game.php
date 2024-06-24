<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::table('ranks', static function (Blueprint $table): void {
            $table->timestamp('from')->nullable();
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }

    public function down(): void
    {
        Schema::table('ranks', static function (Blueprint $table): void {
            $table->dropColumn('from');
            $table->timestamps();
        });
    }
};
