<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\LeaguesWidget;
use App\Models\Game;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class Leagues extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.leagues';

    protected function getHeaderWidgets(): array
    {
        return [
            LeaguesWidget::class
        ];
    }
}
