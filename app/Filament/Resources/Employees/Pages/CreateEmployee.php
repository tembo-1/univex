<?php

namespace App\Filament\Resources\Employees\Pages;

use App\Filament\Resources\Employees\EmployeeResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $user = User::query()
                ->create([
                    'email'         => $data['email'],
                    'password'      => $data['password'],

                ]);

            $employee = $user->employee()->create([
                'user_id'       => $user->id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'middle_name' => $data['middle_name'],
                'internal_phone' => preg_replace('/[^\d]/', '', $data['internal_phone']),
                'is_active' => $data['is_active'],
                'description' => $data['description'],
            ]);

            $adminRoles = Role::query()->whereIn('id', $data['user_roles'])
                ->where('guard_name', 'admin')
                ->get();

            $user->syncRoles($adminRoles);

            return $employee;
        });

    }
}
