<?php

namespace App\Filament\Resources\Vacancies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class VacanciesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Название вакансии')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->limit(50),

                TextColumn::make('salary')
                    ->label('Зарплата')
                    ->money('rub')
                    ->sortable()
                    ->default('-')
                    ->alignCenter()
                    ->color('success'),

                TextColumn::make('experience')
                    ->label('Опыт')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'Нет опыта' => 'info',
                        '1-3 года' => 'warning',
                        '3+ года' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Нет вакансий')
            ->emptyStateDescription('Создайте первую вакансию')
            ->defaultSort('created_at', 'desc');
    }
}
