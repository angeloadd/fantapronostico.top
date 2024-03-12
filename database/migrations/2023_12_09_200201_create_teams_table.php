<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    private const TABLE_NAME = 'teams';

    public function up(): void
    {
        Schema::create(
            self::TABLE_NAME,
            static function (Blueprint $table): void {
                $table->id();
                $table->string('name');
                $table->string('code');
                $table->string('logo');
                $table->boolean('is_national');
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
