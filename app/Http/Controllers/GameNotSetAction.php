<?php

declare(strict_types=1);

namespace App\Http\Controllers;

final class GameNotSetAction extends Controller
{
    public function __invoke()
    {
        return view('errors..nextGame.notSet');
    }
}