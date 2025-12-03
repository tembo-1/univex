<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::query()->truncate();

        Role::query()->insert([
            [
                'name' 			=> 'Менеджер',
                'guard_name' 	=> 'admin'
            ],
            [
                'name' 			=> 'Клиент',
                'guard_name' 	=> 'web'
            ],
            [
                'name' 			=> 'Администратор',
                'guard_name' 	=> 'admin'
            ]
        ]);
    }
}
