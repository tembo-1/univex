<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function fillForm(): void
    {
        $map = [
            'callbacks' => 'Обратные звонки',
            'catalogs' => 'Каталоги',
            'clients' => 'Клиенты',
            'contacts' => 'Контакты',
            'employees' => 'Сотрудники',
            'loginlogs' => 'Логи входов',
            'mailingcampaigns' => 'Рассылки',
            'manufacturers' => 'Производители',
            'manufactureviews' => 'Просмотры производителей',
            'menus' => 'Меню',
            'notifications' => 'Уведомления',
            'orders' => 'Заказы',
            'posts' => 'Статьи',
            'products' => 'Товары',
            'productviews' => 'Просмотры товаров',
            'refunds' => 'Возвраты',
            'roles' => 'Роли',
            'searchviews' => 'Поисковые запросы',
            'settings' => 'Настройки',
            'sitepages' => 'Страницы сайта',
            'vacancies' => 'Вакансии',
            'warehouses' => 'Склады',
            'navigationorder' => 'Порядок меню',
        ];


        $dbPermissions = $this->record->permissions->pluck('name')->toArray();

        $selectPermissions = [];
        foreach ($dbPermissions as $dbPermission) {
            // 'callbacks' → 'Callbacks'
            $selectKey = ($dbPermission);
            if (isset($map[$selectKey])) {
                $selectPermissions[] = $selectKey;
            }
        }

        $data = [
            'name' => $this->record->name,
            'permissions' => $selectPermissions, // ['Callbacks', 'LoginLogs']
        ];

        $this->form->fill($data);
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return DB::transaction(function () use ($data, $record) {
            $record->update(['name' => $data['name']]);

            $permissionNames = collect($data['permissions'])
                ->map(fn($item) => strtolower($item))
                ->toArray();

            $record->syncPermissions($permissionNames);

            return $record;
        });
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
