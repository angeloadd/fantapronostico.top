<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Filament\Widgets\LeaguesWidget;
use Filament\Pages\Page;

final class Leagues extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.leagues';

    protected function getHeaderWidgets(): array
    {
        return [
            LeaguesWidget::class,
        ];
    }
}
