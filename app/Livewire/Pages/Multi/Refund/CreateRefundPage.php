<?php

namespace App\Livewire\Pages\Multi\Refund;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Refund;
use App\Models\RefundConversation;
use App\Models\RefundItem;
use App\Models\RefundType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CreateRefundPage extends Component
{
    use WithFileUploads;

    public Collection $orders;
    public Collection $orderItems;
    public Collection $refundTypes;
    public int $orderId;

    public string $comment = '';

    public array $uploadedFiles = [];

    // Массивы для данных из формы
    public array $formData = [
        'selected_items' => [],
        'quantities' => [],
        'reasons' => [],
        'photos' => [],
        'video' => [],
    ];

    public function mount()
    {
        $this->orders = Order::query()
            ->where('user_id', auth()->id())
//            ->where('order_status_id', 2)
            ->get();

        $this->refundTypes = RefundType::all();
        $this->orderItems = collect();
    }

    public function loadOrderItems()
    {
        $this->orderItems = Order::query()
            ->firstWhere('id', $this->orderId)
            ->orderItems;
    }

    public function processFormData($data)
    {
        $this->formData = $data;

        $selectedOrderItems = collect($this->formData['selected_items'])->map(function (bool $flag, $id) {
            if ($flag) {
                $orderItem = OrderItem::query()->find($id);
                $quantity = $this->formData['quantities'][$orderItem->id];
                $refundTypeId = $this->formData['reasons'][$orderItem->id];

                if ($quantity > $orderItem->quantity) {
                    $this->dispatch('showToast',
                        type: 'error',
                        message: 'Количество заказанного товара меньше, чем пытаетесь вернуть!'
                    );

                    return;
                } else {
                    return [
                        'order_item_id' => $orderItem->id,
                        'quantity' => $quantity,
                        'refund_type_id' => $refundTypeId,
                    ];
                }
            }
        })
            ->filter()
            ->values();

        if ($selectedOrderItems->isEmpty()) {
            $this->dispatch('showToast',
                type: 'error',
                message: 'Выберите товары для возврата!'
            );

            return;
        }

        $this->processFiles($data);

        if (empty($this->uploadedFiles)) {
            $this->dispatch('showToast',
                type: 'error',
                message: 'Прикрепите фото!'
            );

            return;
        }

        $refund = Refund::query()
            ->create([
                'order_id' => $this->orderId,
                'comment' => $this->comment,
                'refund_status_id' => 1,
            ]);

        $selectedOrderItems->each(function ($info) use ($refund) {
            RefundItem::query()->create([
                'refund_id'         => $refund->id,
                'order_item_id'     => $info['order_item_id'],
                'refund_type_id'    => $info['refund_type_id'],
                'quantity'          => $info['quantity'],
            ]);
        });

        RefundConversation::query()
            ->create([
               'refund_id' => $refund->id,
               'user_id' => auth()->id(),
               'message' => $this->comment
            ]);

        collect($this->uploadedFiles['photos'])->map(function ($photo) use ($refund) {
            $content = Storage::disk('public')->get($photo['path']);

            $fileName = uniqid() . '_' . ($photo['original_name'] ?? 'photo.jpg');

            $minioPath = 'refunds/'. $refund->id .'/photos/' . $fileName;

            Storage::disk('documents')->put($minioPath, $content);
            Storage::disk('public')->delete($photo['path']);
        });

        $this->dispatch('showToast',
            type: 'success',
            message: 'Заявка на возврат успешно создана!'
        );

        $this->redirect(route('refunds.show', $refund->id));
    }

    protected function processFiles($data)
    {
        $this->uploadedFiles = [];

        foreach ($data['photos'] as $index => $photoData) {
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

        // Обрабатываем видео
        foreach ($data['videos'] as $index => $videoData) {
            if (isset($videoData['data'])) {
                $path = $this->saveBase64File(
                    $videoData['data'],
                    'videos',
                    $videoData['name'] ?? "video_{$index}.mp4"
                );

                if ($path) {
                    $this->uploadedFiles['videos'][] = [
                        'path' => $path,
                        'original_name' => $videoData['name'] ?? null,
                        'type' => $videoData['type'] ?? null,
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

    public function updatedOrderId()
    {
        $this->loadOrderItems();
        $this->dispatch('init-selects');
    }

    public function submit()
    {

    }

    public function render()
    {
        return view('livewire.pages.multi.refund.create-refund-page');
    }
}
