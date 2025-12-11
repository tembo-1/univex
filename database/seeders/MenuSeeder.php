<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::query()->truncate();
        MenuItem::query()->truncate();

        Menu::query()->insert([
            [
                'name'          => 'Каталог',
                'slug'          => 'catalog',
                'on_footer'     => true,
                'site_page_id'  => null,
                'created_at'    => now(),
            ],
            [
                'name'          => 'Клиентам',
                'slug'          => 'to-clients',
                'on_footer'     => true,
                'site_page_id'  => null,
                'created_at'    => now(),
            ],
            [
                'name'          => 'Поставщикам',
                'slug'          => 'to-suppliers',
                'on_footer'     => true,
                'site_page_id'  => null,
                'created_at'    => now(),
            ],
            [
                'name'          => 'О компании',
                'slug'          => 'about',
                'on_footer'     => true,
                'site_page_id'  => null,
                'created_at'    => now(),
            ],
            [
                'name'          => 'Контакты',
                'slug'          => 'contacts',
                'on_footer'     => false,
                'site_page_id'  => 2,
                'created_at'    => now(),
            ],
        ]);

        MenuItem::query()
            ->insert([
                // КАТАЛОГ
                [
                    'name'          => 'Каталог',
                    'slug'          => 'catalog',
                    'menu_id'       => 1,
                    'site_page_id'  => 3,

                ],
                [
                    'name'          => 'PDF каталоги',
                    'slug'          => 'pdf-catalogs',
                    'menu_id'       => 1,
                    'site_page_id'  => 4,

                ],

                // КЛИЕНТАМ
                [
                    'name'          => 'Как стать клиентом',
                    'slug'          => 'become-client',
                    'menu_id'       => 2,
                    'site_page_id'  => 5,

                ],
                [
                    'name'          => 'Договора',
                    'slug'          => 'contracts',
                    'menu_id'       => 2,
                    'site_page_id'  => 6,

                ],
                [
                    'name'          => 'Претензии и возврат',
                    'slug'          => 'claims-and-refunds-clients',
                    'menu_id'       => 2,
                    'site_page_id'  => 7,

                ],
                [
                    'name'          => 'Доставка',
                    'slug'          => 'delivery',
                    'menu_id'       => 2,
                    'site_page_id'  => 8,

                ],

                // О компании
                [
                    'name'          => 'ООО «АвтопартУнивекс»',
                    'slug'          => 'about',
                    'menu_id'       => 4,
                    'site_page_id'  => 9,

                ],
                [
                    'name'          => 'Реквизиты',
                    'slug'          => 'requisites',
                    'menu_id'       => 4,
                    'site_page_id'  => 10,

                ],
                [
                    'name'          => 'Вакансии',
                    'slug'          => 'vacancies',
                    'menu_id'       => 4,
                    'site_page_id'  => 11,

                ],
                [
                    'name'          => 'Маркетинговые материалы',
                    'slug'          => 'marketing-materials',
                    'menu_id'       => 4,
                    'site_page_id'  => 12,

                ],

                // Поставщикам
                [
                    'name'          => 'Как стать поставщиком',
                    'slug'          => 'become-suppliers',
                    'menu_id'       => 3,
                    'site_page_id'  => 13,

                ],
                [
                    'name'          => 'Претензии и возврат',
                    'slug'          => 'claims-and-refunds-suppliers',
                    'menu_id'       => 3,
                    'site_page_id'  => 7,
                ],
            ]);
    }
}
