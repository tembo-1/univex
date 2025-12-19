<?php

namespace App\Filament\Resources\Notifications\Tables;

use App\Models\Notification;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class NotificationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Уведомление')
                    ->searchable()
                    ->sortable()
                    ->description(fn(Notification $record) =>
                    strlen($record->content) > 100
                        ? substr(strip_tags($record->content), 0, 100) . '...'
                        : strip_tags($record->content)
                    )
                    ->wrap()
                    ->limit(30)
                    ->tooltip(fn(Notification $record) => $record->title)
                    ->weight('semibold'),

                TextColumn::make('notificationType.name')
                    ->label('Тип показа')
                    ->badge()
                    ->sortable()
                    ->searchable()
                    ->colors([
                        'all' => 'gray',
                        'authenticated' => 'blue',
                        'guests' => 'yellow',
                        'admins' => 'danger',
                        'managers' => 'warning',
                        'users' => 'success',
                        'vip' => 'purple',
                    ])
                    ->icons([
                        'all' => 'heroicon-o-user-group',
                        'authenticated' => 'heroicon-o-lock-closed',
                        'guests' => 'heroicon-o-user',
                        'admins' => 'heroicon-o-shield-check',
                        'managers' => 'heroicon-o-briefcase',
                        'users' => 'heroicon-o-users',
                        'vip' => 'heroicon-o-star',
                    ])
                    ->formatStateUsing(fn($state) => match($state) {
                        'Все посетители' => 'Все',
                        'Авторизованные пользователи' => 'Авторизованные',
                        'Гости' => 'Гости',
                        'Администраторы' => '🛡Админы',
                        'Менеджеры' => 'Менеджеры',
                        'Пользователи' => 'Пользователи',
                        default => $state,
                    }),

                // Группа получателей с цветовым кодированием
                TextColumn::make('notificationRecipientGroup.name')
                    ->label('Для кого')
                    ->badge()
                    ->sortable()
                    ->searchable()
                    ->colors([
                        'all' => 'gray',
                        'authenticated' => 'blue',
                        'guests' => 'yellow',
                        'admins' => 'danger',
                        'managers' => 'warning',
                        'users' => 'success',
                        'vip' => 'purple',
                    ])
                    ->icons([
                        'all' => 'heroicon-o-user-group',
                        'authenticated' => 'heroicon-o-lock-closed',
                        'guests' => 'heroicon-o-user',
                        'admins' => 'heroicon-o-shield-check',
                        'managers' => 'heroicon-o-briefcase',
                        'users' => 'heroicon-o-users',
                        'vip' => 'heroicon-o-star',
                    ])
                    ->formatStateUsing(fn($state) => match($state) {
                        'Все посетители' => 'Все',
                        'Авторизованные пользователи' => 'Авторизованные',
                        'Гости' => 'Гости',
                        'Администраторы' => '🛡Админы',
                        'Менеджеры' => 'Менеджеры',
                        'Пользователи' => 'Пользователи',
                        default => $state,
                    }),

                ToggleColumn::make('is_active')
                    ->label('Статус')
                    ->sortable()
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->tooltip(fn($state) => $state ? 'Активно' : 'Неактивно'),

                TextColumn::make('starts_at')
                    ->label('Начало')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->placeholder('Сразу')
                    ->color(fn($state) => $state && now()->greaterThan($state) ? 'success' : 'warning')
                    ->icon(fn($state) => $state ? 'heroicon-o-calendar' : 'heroicon-o-play')
                    ->description('Дата начала'),

                TextColumn::make('ends_at')
                    ->label('Окончание')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->placeholder('Бессрочно')
                    ->color(fn($state) => $state && now()->greaterThan($state) ? 'danger' : 'gray')
                    ->icon(fn($state) => $state ? 'heroicon-o-calendar' : 'heroicon-o-clock')
                    ->description('Дата окончания'),

                // Дата создания с relative time
                TextColumn::make('created_at')
                    ->label('Создано')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->color('gray')
                    ->icon('heroicon-o-calendar')
                    ->description(fn($record) => $record->created_at->format('d.m.Y H:i')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->deferLoading();
    }
}
