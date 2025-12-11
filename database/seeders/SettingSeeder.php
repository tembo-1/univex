<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::query()->truncate();

        $settings = [
            // Основные реквизиты
            [
                'key' => 'org_full_name',
                'value' => 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "АВТОПАРТУНИВЕКС"',
                'description' => 'Полное наименование организации',
            ],
            [
                'key' => 'org_short_name',
                'value' => 'ООО "АВТОПАРТУНИВЕКС"',
                'description' => 'Сокращенное наименование',
            ],
            [
                'key' => 'org_ogrn',
                'value' => '1085003005449',
                'description' => 'ОГРН',
            ],
            [
                'key' => 'org_ogrn_date',
                'value' => '28.08.2008',
                'description' => 'Дата присвоения ОГРН',
            ],
            [
                'key' => 'org_registration_certificate',
                'value' => 'Серия 50 № 011187208',
                'description' => '№ Св. о гос.регистрации',
            ],

            // Налоговые
            [
                'key' => 'org_inn',
                'value' => '5003083149',
                'description' => 'ИНН',
            ],
            [
                'key' => 'org_kpp',
                'value' => '775101001',
                'description' => 'КПП',
            ],

            // Банковские реквизиты
            [
                'key' => 'org_bank_name',
                'value' => 'АО «Райффайзенбанк»',
                'description' => 'Наименование банка',
            ],
            [
                'key' => 'org_bank_address',
                'value' => '129090, г.Москва, ул. Троицкая, 17/1',
                'description' => 'Адрес банка',
            ],
            [
                'key' => 'org_bik',
                'value' => '044525700',
                'description' => 'БИК',
            ],
            [
                'key' => 'org_correspondent_account',
                'value' => '30101810200000000700',
                'description' => 'Корреспондентский счет',
            ],
            [
                'key' => 'org_payment_account',
                'value' => '40702810100001416314',
                'description' => 'Расчетный счет',
            ],

            // Коды
            [
                'key' => 'org_okpo',
                'value' => '86726447',
                'description' => 'Код по ОКПО',
            ],
            [
                'key' => 'org_okved',
                'value' => '45.3; 45.31.1; 45.31.2; 45.32; 46.62; 46.69',
                'description' => 'Коды по ОКВЭД',
            ],
            [
                'key' => 'org_oktmo',
                'value' => '45931000000',
                'description' => 'Код по ОКТМО',
            ],
            [
                'key' => 'org_okato',
                'value' => '45297556102',
                'description' => 'Код по ОКАТО',
            ],
            [
                'key' => 'org_okfs',
                'value' => '34',
                'description' => 'Код по ОКФС',
            ],
            [
                'key' => 'org_okopf',
                'value' => '12300',
                'description' => 'Код по ОКОПФ',
            ],

            // Адреса
            [
                'key' => 'org_legal_address',
                'value' => '108836, Г. МОСКВА, ВН. ТЕР. Г. ГОРОДСКОЙ ОКРУГ ТРОИЦК, УЛ. ЧАРОИТОВАЯ, Д. 5, СТР. 49',
                'description' => 'Юридический адрес',
            ],
            [
                'key' => 'org_actual_address',
                'value' => '108836, Г. МОСКВА, ВН. ТЕР. Г. ГОРОДСКОЙ ОКРУГ ТРОИЦК, УЛ. ЧАРОИТОВАЯ, Д. 5, СТР. 49',
                'description' => 'Фактический адрес',
            ],
            [
                'key' => 'org_mailing_address',
                'value' => '108836,г. Москва, поселение Десеновское, ОПС, а/я 2563',
                'description' => 'Почтовый адрес',
            ],

            // Контакты
            [
                'key' => 'org_phone',
                'value' => '+7 (495) 739-72-10/11/12',
                'description' => 'Телефон/факс',
            ],
            [
                'key' => 'org_website',
                'value' => 'https://www.univex.ru/',
                'description' => 'Сайт организации',
            ],

            // Руководство
            [
                'key' => 'org_general_director',
                'value' => 'Барнолицкий Глеб Витальевич',
                'description' => 'Генеральный директор',
            ],
            [
                'key' => 'org_chief_accountant',
                'value' => 'Захарова Светлана Николаевна',
                'description' => 'Главный бухгалтер',
            ],

            // Другие настройки (можно добавлять)
            [
                'key' => 'site_email',
                'value' => 'info@univex.ru',
                'description' => 'Основной email сайта',
            ],
            [
                'key' => 'site_phone',
                'value' => '+7 (495) 739-72-10',
                'description' => 'Основной телефон',
            ],
            [
                'key' => 'site_address',
                'value' => 'Москва, район Троицк,Чароитовая улица, 5, стр. 49',
                'description' => 'Адрес для контактов',
            ],
            [
                'key' => 'site_working_hours',
                'value' => 'Пн-Пт: 9:00-18:00',
                'description' => 'Время работы',
            ],
            [
                'key' => 'site_parking',
                'value' => 'Парковка: пн–вс, кроме праздников, с 8:00 до 21:00 ч — 450 ₽/ч; с 21:00 до 8:00 ч — 200 ₽/ч',
                'description' => 'Парковка',
            ],
            [
                'key' => 'site_how_to_get',
                'value' => 'Двигаясь по внутренней стороне Садового кольца свернуть направо на улицу Спиридоновка.',
                'description' => 'Как добраться',
            ],
            [
                'key' => 'site_vk',
                'value' => '#',
                'description' => 'Ссылка на VK',
            ],
            [
                'key' => 'site_whatsapp',
                'value' => '#',
                'description' => 'Ссылка на WhatsApp',
            ],
            [
                'key' => 'site_telegram',
                'value' => '#',
                'description' => 'Ссылка на telegram',
            ],
            [
                'key' => 'site_max',
                'value' => '#',
                'description' => 'Ссылка на MAX',
            ]
        ];


        Setting::query()->insert($settings);
    }
}
