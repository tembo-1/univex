<?php

namespace App\Filament\Resources\Vacancies\Schemas;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VacancyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Название вакансии')
                    ->required()
                    ->maxLength(255),

                RichEditor::make('content')
                    ->label('Содержание')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('salary')
                    ->label('Зарплата')
                    ->prefix('₽'),

                TextInput::make('experience')
                    ->label('Опыт работы')
                    ->placeholder('Например: 1-3 года'),
            ]);
    }
}
