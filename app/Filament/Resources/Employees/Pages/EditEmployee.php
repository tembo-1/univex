<?php

namespace App\Filament\Resources\Employees\Pages;

use App\Filament\Resources\Employees\EmployeeResource;
use App\Models\Employee;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Данные менеджера обновлены';
    }

    protected function fillForm(): void
    {
        $data = $this->record;

        /** @var User $user */
        $user = $data->user;

        $data['email'] = $user->email;

        $data['user_roles'] = $user->roles()->pluck('id')->toArray();

        $this->form->fill($data->toArray());
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        /** @var User $user */
        $user = $record->user;

        $record->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'middle_name' => $data['middle_name'],
            'internal_phone' => $data['internal_phone'],
            'is_active' => $data['is_active'],
            'description' => $data['description'],
        ]);

        if (isset($data['user_roles'])) {
            $adminRoles = Role::whereIn('id', $data['user_roles'])
                ->where('guard_name', 'admin')
                ->get();

            $record->user->syncRoles($adminRoles);
        }

        if ($data['password']) {
            $user->update([
                'email' => $data['email'],
                'password' => $data['password'],
            ]);
        }

        $user->update([
            'email' => $data['email'],
        ]);

        return $record;
    }
}
