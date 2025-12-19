<?php

namespace App\Filament\Resources\MailingCampaigns\Schemas;

use App\Models\MailingStatus;
use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class MailingCampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Основная информация
                Section::make('Основная информация')
                    ->schema([
                        TextInput::make('name')
                            ->label('Название рассылки')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('subject')
                            ->label('Тема письма')
                            ->required()
                            ->maxLength(255),

                        Select::make('mailing_status_id')
                            ->label('Статус')
                            ->relationship('mailingStatus', 'name')
                            ->required()
                            ->default(fn() => MailingStatus::where('slug', 'draft')->first()?->id),

                        Toggle::make('send_to_all')
                            ->label('Отправить всем пользователям')
                            ->live(),
                    ])->columns(2),

                // Планирование
                Section::make('Планирование')
                    ->schema([
                        DateTimePicker::make('scheduled_at')
                            ->label('Запланировать отправку')
                            ->minDate(now())
                            ->helperText('Оставьте пустым для немедленной отправки'),
                    ]),

                // Вложения к письму
//                Section::make('Вложения к письму')
//                    ->description('Прикрепите файлы, которые будут отправлены вместе с письмом')
//                    ->schema([
//                        Repeater::make('attachments')
//                            ->label('Файлы')
//                            ->schema([
//                                FileUpload::make('file')
//                                    ->label('Файл')
//                                    ->required()
//                                    ->disk('public')
//                                    ->directory('mailing-attachments')
//                                    ->preserveFilenames()
//                                    ->maxSize(10240) // 10MB
//                                    ->acceptedFileTypes([
//                                        'application/pdf',
//                                        'application/xlsx',
//                                        'image/jpeg',
//                                        'image/png',
//                                        'image/gif',
//                                        'application/msword',
//                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
//                                        'application/vnd.ms-excel',
//                                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
//                                        'text/plain',
//                                    ])
//                                    ->helperText('Максимальный размер: 10MB. Разрешенные форматы: PDF, изображения, документы Word/Excel, текстовые файлы')
//                                    ->columnSpanFull(),
//
//                                TextInput::make('description')
//                                    ->label('Описание файла')
//                                    ->placeholder('Например: Каталог товаров, Прайс-лист и т.д.')
//                                    ->maxLength(255)
//                                    ->helperText('Необязательное описание для внутреннего использования'),
//                            ])
//                            ->columns(1)
//                            ->defaultItems(0)
//                            ->maxItems(5)
//                            ->reorderable()
//                            ->cloneable()
//                            ->collapsible()
//                            ->itemLabel(fn (array $state): ?string =>
//                                $state['description'] ??
//                                (isset($state['file']) ? basename($state['file']) : null)
//                            )
//                            ->helperText('Можно прикрепить до 5 файлов. Перетаскивайте для изменения порядка')
//                            ->columnSpanFull(),
//                    ])
//                    ->collapsible()
//                    ->collapsed(),

                // Содержание письма
                Section::make('Содержание письма')
                    ->columnSpanFull()
                    ->schema([
                        RichEditor::make('content')
                            ->label('Содержание')
                            ->required()
                            ->fileAttachmentsDisk('documents')
                            ->fileAttachmentsDirectory('mailing-content')
                            ->fileAttachmentsVisibility('public')
                            ->maxLength(5000)
                            ->extraInputAttributes(['style' => 'min-height: 200px;'])
                            ->toolbarButtons([
                                ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                                ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                ['table', 'attachFiles'],
                                ['undo', 'redo'],
                            ])
                            ->fileAttachmentsAcceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/gif',
                                'image/webp',
                                'image/svg+xml',
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.ms-powerpoint',
                                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                'text/plain',
                                'text/csv',
                                'application/zip',
                                'application/x-rar-compressed',
                                'application/x-7z-compressed',
                            ])
                            ->helperText('Используйте форматирование для лучшего восприятия. Максимально 5000 символов.')
                            ->columnSpanFull(),
                    ]),

//                // Получатели (если не "всем")
//                Section::make('Получатели')
//                    ->schema([
//                        Select::make('user_roles')
//                            ->label('Роли пользователя')
//                            ->required()
//                            ->multiple()
//                            ->searchable()
//                            ->preload()
//                            ->helperText('Выберите роли для этого менеджера')
//                            ->suffixIcon('heroicon-m-shield-check')
//                            ->options(function ($record) {
//                                return User::query()
//                                    ->find(24)
//                                    ->pluck('email', 'id')
//                                    ->toArray();
//                            })
//                            ->rules(['array']),
//                    ])->hidden(fn(Get $get) => $get('send_to_all')),
            ]);
    }
}
