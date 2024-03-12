<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    private const TABLE_NAME = 'players';

    public function up(): void
    {
        Schema::create(
            self::TABLE_NAME,
            static function (Blueprint $table): void {
                $table->id();
                $table->string('displayed_name');
                $table->string('first_name');
                $table->string('last_name');
                $table->foreignId('club_id')
                    ->nullable()
                    ->constrained('teams')
                    ->nullOnDelete()
                    ->cascadeOnUpdate();
                $table->foreignId('national_id')
                    ->nullable()
                    ->constrained('teams')
                    ->nullOnDelete()
                    ->cascadeOnUpdate();
                $table->timestamps();
            }
        );

        DB::connection()->getPdo()->exec(
            <<<'SQL'
alter table players
    add constraint national_club
    check ( players.club_id <> players.national_id )
SQL
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
