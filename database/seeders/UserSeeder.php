<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->truncate();

        $user = User::query()->create([
            'password' => 'root',
            'email' => 'root@ya.ru',
        ]);

        $role = Role::query()
            ->firstWhere('name', 'Администратор');

        $user->assignRole($role);
    }
}
