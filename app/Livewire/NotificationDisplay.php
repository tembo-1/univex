<?php

namespace App\Livewire;

use App\Models\Notification;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class NotificationDisplay extends Component
{
    public $notifications;
    public $hiddenNotifications = [];

    public function mount()
    {
        $this->hiddenNotifications = json_decode(Cookie::get('hidden_notifications', '[]'), true);
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Notification::query()
            ->where('is_active', true)
            ->where('notification_type_id', 1)
            ->whereNotIn('id', $this->hiddenNotifications)
            ->latest()
            ->get();
    }

    public function hideNotification($notificationId)
    {
        $notification = Notification::query()
            ->find($notificationId);

        if ($notification) {
            $this->hiddenNotifications[] = $notificationId;
            $this->hiddenNotifications = array_unique($this->hiddenNotifications);

            // Сохраняем в cookie на 30 дней
            Cookie::queue('hidden_notifications',
                json_encode($this->hiddenNotifications),
                $notification->show_again_after ?? 86400 * 365
            );
        }

        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notification-display');
    }
}
