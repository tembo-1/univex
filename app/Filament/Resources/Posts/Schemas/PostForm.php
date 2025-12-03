<?php

namespace App\Filament\Resources\Posts\Schemas;

use Asmit\FilamentUpload\Enums\PdfViewFit;
use Asmit\FilamentUpload\Forms\Components\AdvancedFileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columnSpanFull()
                    ->schema([
                        // Левая колонка - основное содержимое
                        Section::make('Содержание поста')
                            ->description('Основная информация и контент')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Заголовок')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Введите заголовок поста')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        // Автогенерация slug из заголовка
                                        if (!empty($state)) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),

                                TextInput::make('slug')
                                    ->label('URL-адрес (slug)')
                                    ->required()
                                    ->maxLength(255)
                                    ->prefix('posts/')
                                    ->unique('posts', 'slug', ignoreRecord: true)
                                    ->placeholder('url-adres-posta')
                                    ->helperText('Уникальный идентификатор для URL'),

//                                AdvancedFileUpload::make('file')
//                                    ->pdfToolbar(true)
//                                    ->label('Upload PDF')
//                                    ->pdfPreviewHeight(400) // Customize preview height
//                                    ->pdfDisplayPage(1) // Set default page
//                                    ->pdfToolbar(true) // Enable toolbar
//                                    ->pdfZoomLevel(100) // Set zoom level
//                                    ->pdfFitType(PdfViewFit::FIT) // Set fit type
//                                    ->pdfNavPanes(true), // Enable navigation panes,

                                RichEditor::make('content')
                                    ->label('Содержание')
                                    ->required()
                                    ->fileAttachmentsDisk('documents')
                                    ->fileAttachmentsDirectory('posts')
                                    ->fileAttachmentsVisibility('public')
                                    ->maxLength(5000)
                                    ->fileAttachmentsAcceptedFileTypes([
                                        'image/jpeg',
                                        'image/png',
                                        'image/gif',
                                        'image/webp',
                                        'image/svg+xml',
                                    ])
                                    ->extraInputAttributes(['style' => 'min-height: 200px;'])
                                    ->toolbarButtons([
                                        ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                                        ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                                        ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                        ['table', 'attachFiles'],
                                        ['undo', 'redo'],
                                    ])
                                    ->columnSpanFull(),

                                FileUpload::make('attachments')
                                    ->label('Прикрепленные файлы')
                                    ->disk('documents')
                                    ->directory('posts')
                                    ->visibility('public')
                                    ->multiple()
                                    ->downloadable()
                                    ->acceptedFileTypes([
                                        'image/jpeg',
                                        'image/png',
                                        'image/gif',
                                        'image/webp',
                                        'image/svg+xml',

                                        // Документы
                                        'application/pdf',
                                        'application/msword', // .doc
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx
                                        'application/vnd.ms-excel', // .xls
                                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
                                        'application/vnd.ms-powerpoint', // .ppt
                                        'application/vnd.openxmlformats-officedocument.presentationml.presentation', // .pptx

                                        // Текстовые файлы
                                        'text/plain',
                                        'text/csv',

                                        // Архивы
                                        'application/zip',
                                        'application/x-rar-compressed',
                                        'application/x-7z-compressed',

                                        // Другие
                                        'application/json',
                                        'application/xml',
                                    ])
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(2),

                        // Правая колонка - настройки
                        Section::make('Настройки публикации')
                            ->description('Управление видимостью и временем публикации')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Toggle::make('is_published')
                                    ->label('Опубликовано')
                                    ->default(false)
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->inline(false)
                                    ->helperText('Включите для публикации поста'),

                                DateTimePicker::make('published_at')
                                    ->label('Дата публикации')
                                    ->default(now())
                                    ->displayFormat('d.m.Y H:i')
                                    ->helperText('Когда пост станет доступен для просмотра'),

                                FileUpload::make('image')
                                    ->label('Главное изображение')
                                    ->image()
                                    ->imageEditor()
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('800')
                                    ->imageResizeTargetHeight('450')
                                    ->disk('documents')
                                    ->directory('posts')
                                    ->visibility('public')
                                    ->preserveFilenames()
                                    ->imagePreviewHeight(250)
                                    ->loadingIndicatorPosition('left')
                                    ->panelAspectRatio('2:1')
                                    ->panelLayout('integrated')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->uploadButtonPosition('left')
                                    ->uploadProgressIndicatorPosition('left')
                                    ->helperText('Рекомендуемый размер: 800x450px')
                                    ->required()
                                    ->maxSize(2048),
                            ])
                            ->columnSpan(1),
                    ])
                    ->columns(3),
            ]);
    }
}
