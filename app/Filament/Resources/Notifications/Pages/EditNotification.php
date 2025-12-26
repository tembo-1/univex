<?php

namespace App\Filament\Resources\Notifications\Pages;

use App\Filament\Resources\Notifications\NotificationResource;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditNotification extends EditRecord
{
    protected static string $resource = NotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function fillForm(): void
    {
        $data = $this->record;

        if ($this->record->notificationRecipients()->exists()) {
            $data['selected_users'] = $this->record->notificationRecipients
                ->pluck('user_id')
                ->toArray();
        }

        $this->form->fill($data->toArray());
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return DB::transaction(function () use ($data, $record) {
            $record->update([
                'title'                             => $data['title'],
                'content'                           => $data['content'],
                'starts_at'                         => $data['starts_at'],
                'ends_at'                           => $data['ends_at'],
                'is_active'                         => $data['is_active'],
                'show_again_after'                  => $data['show_again_after'],
                'notification_recipient_group_id'   => $data['notification_recipient_group_id'],
                'notification_type_id'              => $data['notification_type_id'],
            ]);

            $record->notificationRecipients()->delete();

            if (isset($data['selected_users'])) {
                collect($data['selected_users'])->each(function ($userId) use ($record) {
                    NotificationRecipient::query()
                        ->create([
                            'notification_id'   => $record->id,
                            'user_id'           => $userId,
                        ]);
                });
            }

            return $record;
        });
    }
}
