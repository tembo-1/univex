<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\ContactGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactGroup::query()->truncate();
        Contact::query()->truncate();

        ContactGroup::query()->insert([
            [
                'name' => 'Продажа запчастей',
                'slug' => Str::slug('Продажа запчастей'),
            ],
            [
                'name' => 'Поставка комплектующих производителям коммерческих транспортных средств',
                'slug' => Str::slug('Поставка комплектующих производителям коммерческих транспортных средств'),
            ]
        ]);

        Contact::query()->insert([
            [
                'name'              => 'Иванов ИВАН ПЕТРОВИЧ',
                'phone'             => '+7 (999) 999-99-99',
                'email'             => 'example@mail.ru',
                'working_hours'     => 'Пн. -Пт. 9:00 - 18:00',
                'contact_group_id'  => 1,
            ],
            [
                'name'              => 'Иванов ИВАН ПЕТРОВИЧ',
                'phone'             => '+7 (999) 999-99-99',
                'email'             => 'example@mail.ru',
                'working_hours'     => 'Пн. -Пт. 9:00 - 18:00',
                'contact_group_id'  => 1,
            ],
            [
                'name'              => 'Иванов ИВАН ПЕТРОВИЧ',
                'phone'             => '+7 (999) 999-99-99',
                'email'             => 'example@mail.ru',
                'working_hours'     => 'Пн. -Пт. 9:00 - 18:00',
                'contact_group_id'  => 1,
            ],
            [
                'name'              => 'Иванов ИВАН ПЕТРОВИЧ',
                'phone'             => '+7 (999) 999-99-99',
                'email'             => 'example@mail.ru',
                'working_hours'     => 'Пн. -Пт. 9:00 - 18:00',
                'contact_group_id'  => 1,
            ],

            [
                'name'              => 'Иванов ИВАН ПЕТРОВИЧ',
                'phone'             => '+7 (999) 999-99-99',
                'email'             => 'example@mail.ru',
                'working_hours'     => 'Пн. -Пт. 9:00 - 18:00',
                'contact_group_id'  => 2,
            ],
            [
                'name'              => 'Иванов ИВАН ПЕТРОВИЧ',
                'phone'             => '+7 (999) 999-99-99',
                'email'             => 'example@mail.ru',
                'working_hours'     => 'Пн. -Пт. 9:00 - 18:00',
                'contact_group_id'  => 2,
            ],
            [
                'name'              => 'Иванов ИВАН ПЕТРОВИЧ',
                'phone'             => '+7 (999) 999-99-99',
                'email'             => 'example@mail.ru',
                'working_hours'     => 'Пн. -Пт. 9:00 - 18:00',
                'contact_group_id'  => 2,
            ],
            [
                'name'              => 'Иванов ИВАН ПЕТРОВИЧ',
                'phone'             => '+7 (999) 999-99-99',
                'email'             => 'example@mail.ru',
                'working_hours'     => 'Пн. -Пт. 9:00 - 18:00',
                'contact_group_id'  => 2,
            ],
        ]);
    }
}
