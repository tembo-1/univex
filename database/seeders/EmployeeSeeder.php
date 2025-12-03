<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Storage::disk('public')->get('univexnav_managers.json');
        $employees = json_decode($json, true);

        $role = Role::query()
            ->firstWhere('name', 'Менеджер');

        collect($employees[2]['data'])->map(function ($employee) use ($role) {
            $user = User::query()
                ->create([
                    'email' => $employee['Email'],
                    'password' => $employee['Password'],
                ]);

            $user->assignRole($role);

            Employee::query()
                ->create([
                    'user_id' => $user->id,
                    'first_name' => $employee['Name'],
                    'last_name' => $employee['Surname'],
                    'middle_name' => $employee['Patronymic'],
                    'internal_phone' => $employee['Mobile'],
                    'description' => $employee['Phone']. PHP_EOL .$employee['Mobile'],
                    'code' => $employee['Code'],
                ]);
        });
    }
}
