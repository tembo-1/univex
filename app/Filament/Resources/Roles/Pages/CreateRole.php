<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $role = Role::query()
                ->create([
                    'name' => $data['name'],
                    'guard_name' => 'admin',
                ]);

            collect($data['permissions'])->each(function ($item) use ($role) {
                $permission = Permission::query()
                    ->firstWhere('name', strtolower($item));

                $role->givePermissionTo($permission);
            });

            return $role;
        });
    }
}
