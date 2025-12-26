<?php

namespace App\Livewire\Pages\Multi\Refund;

use App\Models\Refund;
use App\Models\RefundConversation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class RefundPage extends Component
{
    public Collection $refundItems;
    public ?Collection $refundConversations;
    public int $refundId;
    public ?Refund $refund;

    public ?Collection $images;
    public string $message = '';

    public $formData = [
        'photos' => [],
    ];

    public $uploadedFiles = [];

    public function mount(int $id)
    {
        $this->images = collect();
        $this->refundId = $id;
        $this->refund = Refund::query()->find($id);

        if (!$this->refund) {
            return $this->redirect(route('404'));
        }

        $this->loadData();
    }

    public function loadData()
    {
        $this->refundItems = $this->refund->refundItems;
        $this->updateConversations();
        $this->updateImages();
    }

    public function updateConversations(): void
    {
        $this->refundConversations = $this->refund
            ->refundConversations()
            ->with('user')
            ->get();
    }

    public function updateImages(): void
    {
        $this->images = collect();

        $files = Storage::disk('documents')->files('refunds/'. $this->refund->id .'/photos');

        foreach ($files as $file) {
            $this->images[] = [
                'path' => $file,
                'url' => Storage::disk('documents')->url($file), // Полный URL
                'name' => basename($file), // Имя файла
            ];
        }
    }

    public function processFormData($data)
    {
        $this->processFiles($data);

        if ($this->message) {
            RefundConversation::query()
                ->create([
                    'user_id' => auth()->id(),
                    'message' => $this->message,
                    'refund_id' => $this->refundId,
                ]);
        }

        $photos = $this->uploadedFiles['photos'] ?? [];

        collect($photos)->map(function ($photo) {
            $content = Storage::disk('public')->get($photo['path']);

            $fileName = uniqid() . '_' . ($photo['original_name'] ?? 'photo.jpg');

            $minioPath = 'refunds/'. $this->refundId .'/photos/' . $fileName;

            Storage::disk('documents')->put($minioPath, $content);
            Storage::disk('public')->delete($photo['path']);
        });

        $this->message = '';
        $this->uploadedFiles = [];
        $this->formData = [
            'photos' => [],
        ];

        $this->updateImages();
        $this->updateConversations();
    }

    public function render()
    {
        return view('livewire.pages.multi.refund.refund-page');
    }

    protected function processFiles($data)
    {
        $this->uploadedFiles = [];

        foreach ($data['files'] as $index => $photoData) {
            if (isset($photoData['data'])) {
                $path = $this->saveBase64File(
                    $photoData['data'],
                    'photos',
                    $photoData['name'] ?? "photo_{$index}.jpg"
                );

                if ($path) {
                    $this->uploadedFiles['photos'][] = [
                        'path' => $path,
                        'original_name' => $photoData['name'] ?? null,
                        'type' => $photoData['type'] ?? null,
                    ];
                }
            }
        }
    }

    protected function saveBase64File($base64, $folder, $filename)
    {
        try {
            // Извлекаем содержимое из data:image/png;base64,...
            if (preg_match('/^data:(\w+\/\w+);base64,/', $base64, $matches)) {
                $data = substr($base64, strpos($base64, ',') + 1);
                $data = base64_decode($data);

                // Генерируем уникальное имя файла
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                if (!$extension) {
                    // Пытаемся определить расширение из MIME type
                    $mime = $matches[1];
                    $extension = $this->mimeToExtension($mime);
                }

                $uniqueName = uniqid() . '_' . time() . '.' . $extension;
                $path = storage_path("app/public/tmp/{$folder}/{$uniqueName}");

                // Создаем директорию если нужно
                if (!file_exists(dirname($path))) {
                    mkdir(dirname($path), 0755, true);
                }

                // Сохраняем файл
                file_put_contents($path, $data);

                // Возвращаем относительный путь
                return "tmp/{$folder}/{$uniqueName}";
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function mimeToExtension($mime)
    {
        $mimeMap = [
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/heic' => 'heic',
            'video/mp4' => 'mp4',
            'video/quicktime' => 'mov',
            'video/x-msvideo' => 'avi',
            'video/x-matroska' => 'mkv',
            'video/webm' => 'webm',
        ];

        return $mimeMap[$mime] ?? 'bin';
    }
}
