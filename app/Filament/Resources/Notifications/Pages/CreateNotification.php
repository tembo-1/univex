<?php

namespace App\Filament\Resources\Notifications\Pages;

use App\Filament\Resources\Notifications\NotificationResource;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateNotification extends CreateRecord
{
    protected static string $resource = NotificationResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $notification = Notification::query()
                ->create([
                    'title'                             => $data['title'],
                    'content'                           => $data['content'],
                    'starts_at'                         => $data['starts_at'],
                    'ends_at'                           => $data['ends_at'],
                    'is_active'                         => $data['is_active'],
                    'show_again_after'                  => $data['show_again_after'],
                    'notification_recipient_group_id'   => $data['notification_recipient_group_id'],
                    'notification_type_id'              => $data['notification_type_id'],
                ]);

            if (isset($data['selected_users'])) {
                collect($data['selected_users'])->each(function ($userId) use ($notification) {
                    NotificationRecipient::query()
                        ->create([
                            'notification_id'   => $notification->id,
                            'user_id'           => $userId,
                        ]);
                });
            }

            return $notification;
        });
    }
}
