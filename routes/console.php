<?php

declare(strict_types=1);

use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function (): void {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

$consoleFromModules = glob(__DIR__ . '/../app/Modules/*/Console/console.php');
if ( ! $consoleFromModules) {
    $consoleFromModules = [];
}
foreach ($consoleFromModules as $moduleConsolePath) {
    require $moduleConsolePath;
}

Schedule::command('fp:bot:telegram')
    ->everyThirtyMinutes();
