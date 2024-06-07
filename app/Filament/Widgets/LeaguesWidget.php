<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Modules\Auth\Models\User;
use App\Modules\League\Models\League;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class LeaguesWidget extends BaseWidget
{
    use Table\Concerns\HasQuery;

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query()->with(['leagues'])->whereHas('leagues'))
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('leagues')
                    ->state(static fn (Model $model) => $model->leagues->first()?->name),
                TextColumn::make('status')
                    ->badge()
                    ->state(static fn (Model $model) => $model->leagues->first()?->pivot->status)->color(fn (string $state): string => match ($state) {
                        'accepted' => 'success',
                        'pending' => 'warning',
                    }),
            ])
            ->actions([
                Action::make('accept')
                    ->disabled(static fn (User $user) => $user->leagues->first()?->pivot->status === 'accepted')
                    ->action(
                        static function (User $user): void {
                            $user->leagues()->updateExistingPivot($user->leagues->first()?->id, ['status'=> 'accepted']);
                            $user->save();
                        }
                    ),
            ]);
    }
}