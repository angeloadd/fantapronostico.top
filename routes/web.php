<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', static fn () => view('pages.home'))->name('home');

Route::group([], static function (Router $r): void {
    $routesFromModules = glob(__DIR__ . '/../app/Modules/*/Http/Routes/*.php');
    if ( ! $routesFromModules) {
        $routesFromModules = [];
    }
    foreach ($routesFromModules as $moduleRoutesPath) {
        require $moduleRoutesPath;
    }
});
