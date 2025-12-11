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
use Filament\Schemas\Components\Utilities\Get;
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

                                RichEditor::make('content')
                                    ->label('Содержание')
                                    ->required()
                                    ->reactive()
                                    ->debounce(50)
                                    ->afterStateUpdated(function (RichEditor $component, $state, $set) {
                                        $count = 0;
                                        $modifiedState = preg_replace_callback(
                                            '/<img[^>]+src="([^"]*\.(?:pdf|docx?|xlsx?|pptx?|txt|csv|zip|rar|json|xml)[^"]*)"[^>]*>/i',
                                            function ($matches) use (&$count) {
                                                $count++;
                                                $url = $matches[1];

                                                $filename = basename($url);

                                                $cleanName = pathinfo($filename, PATHINFO_FILENAME);

                                                $fileSize = self::getFileSize($filename);

                                                return '<a href="' . $url . '" target="_blank"> 📄  файл ' . $fileSize . '</a>';
                                            },
                                            $state);

                                        if ($count > 0) {
                                            $set('file', 1);
                                            $component->state($modifiedState);
                                        }
                                    })
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

                                        // Документы (добавьте нужные)
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
                                        'application/json',
                                        'application/xml',
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

                                DateTimePicker::make('starts_at')
                                    ->label('Дата публикации')
                                    ->displayFormat('d.m.Y H:i')
                                    ->timezone('Europe/Moscow')
                                    ->helperText('Когда пост станет доступен для просмотра. Оставьте пустым, если пост доступен сразу'),

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

    private static function getFileSize($fileName)
    {
//        dd($fileName);
        try {
            $path = public_path(parse_url($fileName, PHP_URL_PATH));
            if (file_exists($path)) {
                $size = filesize($path);
                return self::formatBytes($size);
            }
        } catch (\Exception $e) {
            return '';
        }

        return '';
    }

    private static function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        return round($bytes / pow(1024, $pow), $precision) . ' ' . $units[$pow];
    }
}
