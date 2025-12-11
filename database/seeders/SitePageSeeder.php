<?php

namespace Database\Seeders;

use App\Models\SiteBlock;
use App\Models\SiteElement;
use App\Models\SiteElementImage;
use App\Models\SiteElementType;
use App\Models\SitePage;
use Illuminate\Database\Seeder;

class SitePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SitePage::query()->truncate();
        SiteBlock::query()->truncate();
        SiteElement::query()->truncate();
        SiteElementType::query()->truncate();
        SiteElementImage::query()->truncate();

        SitePage::query()
            ->insert([
                [
                    'name'              => 'Главная',
                    'slug'              => 'home',
                    'url'               => '/',
                    'title'             => 'Автозапчасти для грузовиков и автобусов, запчасти для прицепов и полуприцепов. Продажа запчастей для грузовых автомобилей иномарок. – «УНИВЕКС»',
                    'meta_description'  => 'Запчасти для автобусов, запчасти для грузовиков,грузовые автомобили запчасти, запчасти для полуприцепов и прицепов от «УНИВЕКС»',
                    'meta_keywords'     => 'запчасти для грузовиков, запчасти для прицепов, запчасти для грузовых автомобилей, запчасти на автобусы, запчасти грузовики, запчасти на грузовые иномарки, запчасти для полуприцепов, запчасти на грузовики, грузовые автомобили запчасти',
                ],
                [
                    'name'              => 'Контакты',
                    'slug'              => 'contacts',
                    'url'               => 'contacts',
                    'title'             => 'Контакты',
                    'meta_description'  => '',
                    'meta_keywords'     => '',
                ],

                //Каталог
                [
                    'name'              => 'Каталог',
                    'slug'              => 'catalog',
                    'url'               => 'catalog',
                    'title'             => 'Каталог',
                    'meta_description'  => '',
                    'meta_keywords'     => '',
                ],
                [
                    'name'              => 'PDF каталоги',
                    'slug'              => 'pdf-catalogs',
                    'url'               => 'pdf-catalogs',
                    'title'             => 'PDF каталоги',
                    'meta_description'  => '',
                    'meta_keywords'     => '',
                ],

                //Клиентам
                [
                    'name'              => 'Как стать клиентом',
                    'slug'              => 'become-client',
                    'url'               => 'become-client',
                    'title'             => 'Как стать клиентом',
                    'meta_description'  => '',
                    'meta_keywords'     => '',
                ],
                [
                    'name'              => 'Договора',
                    'slug'              => 'contracts',
                    'url'               => 'contracts',
                    'title'             => 'Договора',
                    'meta_description'  => '',
                    'meta_keywords'     => '',
                ],
                [
                    'name'              => 'Претензии и возврат',
                    'slug'              => 'claims-and-refunds',
                    'url'               => 'claims-and-refunds',
                    'title'             => 'Претензии и возврат',
                    'meta_description'  => '',
                    'meta_keywords'     => '',
                ],
                [
                    'name'              => 'Доставка',
                    'slug'              => 'delivery',
                    'url'               => 'delivery',
                    'title'             => 'Доставка',
                    'meta_description'  => '',
                    'meta_keywords'     => '',
                ],

                // О компании
                [
                    'name'              => 'ООО «АвтопартУнивекс»',
                    'slug'              => 'about',
                    'url'               => 'about',
                    'title'             => 'О компании',
                    'meta_description'  => '',
                    'meta_keywords'     => '',
                ],
                [
                    'name'              => 'Реквизиты',
                    'slug'              => 'requisites',
                    'url'               => 'requisites',
                    'title'             => 'Реквизиты',
                    'meta_description'  => '',
                    'meta_keywords'     => '',
                ],
                [
                    'name'              => 'Вакансии',
                    'slug'              => 'vacancies',
                    'url'               => 'vacancies',
                    'title'             => 'Вакансии',
                    'meta_description'  => '',
                    'meta_keywords'     => '',
                ],
                [
                    'name'              => 'Маркетинговые материалы',
                    'slug'              => 'marketing-materials',
                    'url'               => 'marketing-materials',
                    'title'             => 'Маркетинговые материалы',
                    'meta_description'  => '',
                    'meta_keywords'     => '',
                ],
                [
                    'name'              => 'Как стать поставщиком',
                    'slug'              => 'become-suppliers',
                    'url'               => 'become-suppliers',
                    'title'             => 'Как стать поставщиком',
                    'meta_description'  => '',
                    'meta_keywords'     => '',
                ],
                [
                    'name'              => 'Политика конфиденциальности',
                    'slug'              => 'privacy-policy',
                    'url'               => 'privacy-policy',
                    'title'             => 'Политика конфиденциальности',
                    'meta_description'  => '',
                    'meta_keywords'     => '',
                ],
                [
                    'name'              => 'Заказы',
                    'slug'              => 'orders',
                    'url'               => 'orders',
                    'title'             => 'Заказы',
                    'meta_description'  => '',
                    'meta_keywords'     => '',
                ]
            ]);

        SiteElementType::query()
            ->insert([
                [
                    'name' => 'изображение',
                    'slug' => 'image',
                ],
                [
                    'name' => 'текст',
                    'slug' => 'text',
                ],
                [
                    'name' => 'слайдер',
                    'slug' => 'slider',
                ],
                [
                    'name' => 'карточки',
                    'slug' => 'cards',
                ],
                [
                    'name' => 'кастомный текст',
                    'slug' => 'custom-text',
                ],
            ]);

        SiteBlock::query()
            ->insert([
                [
                    'site_page_id'  => 1,
                    'slug'          => 'intro',
                    'name'          => 'Главный блок главной страницы',
                ],
                [
                    'site_page_id'  => 1,
                    'slug'          => 'slider-banners',
                    'name'          => 'Слайдер с баннерами',
                ],
                [
                    'site_page_id'  => 1,
                    'slug'          => 'slider-footer-banners',
                    'name'          => 'Слайдер с офисом',
                ],
                [
                    'site_page_id'  => 5,
                    'slug'          => 'become-client-content',
                    'name'          => 'Как стать клиентом',
                ],
                [
                    'site_page_id'  => 6,
                    'slug'          => 'contracts',
                    'name'          => 'Договора',
                ],
                [
                    'site_page_id'  => 7,
                    'slug'          => 'claims-and-refunds',
                    'name'          => 'Правила принятия претензий на брак/ недостачу/ излишки, выставляемых Покупателем Продавцу',
                ],
                [
                    'site_page_id'  => 8,
                    'slug'          => 'delivery',
                    'name'          => 'Достака',
                ],
                [
                    'site_page_id'  => 13,
                    'slug'          => 'become-suppliers',
                    'name'          => 'Как стать поставщиком',
                ],
                [
                    'site_page_id'  => 14,
                    'slug'          => 'privacy-policy',
                    'name'          => 'Политика конфиденциальности',
                ],
                [
                    'site_page_id'  => 9,
                    'slug'          => 'about-text-up',
                    'name'          => 'О компании',
                ],
                [
                    'site_page_id'  => 9,
                    'slug'          => 'about-slider',
                    'name'          => 'Слайдер о компании',
                ],
                [
                    'site_page_id'  => 9,
                    'slug'          => 'about-cards',
                    'name'          => 'Основные направления деятельности компании',
                ],
                [
                    'site_page_id'  => 9,
                    'slug'          => 'about-slider-footer-banners',
                    'name'          => 'Слайдер с офисом',
                ],
            ]);



        SiteElement::query()->create([
            'site_block_id'  => 1,
            'name' => 'Текст над кнопкой',
            'slug' => 'rules-up',
            'site_element_type_id' => 2,
            'content' => 'Ваш склад запчастей <span>для европейских грузовиков</span>',
        ]);

        SiteElement::query()->create([
            'site_block_id'  => 1,
            'name' => 'Текст под кнопкой',
            'slug' => 'rules-down',
            'site_element_type_id' => 2,
            'content' => 'Склад в Москве. Быстрая доставка по всей России',
        ]);

        SiteElement::query()->create([
            'site_block_id'  => 1,
            'name'  => 'Баннер',
            'slug'  => 'intro-banner',
            'image' => 'site-block-images/01.webp',
            'site_element_type_id' => 1,
        ]);

        SiteElement::query()->create([
            'site_block_id'  => 2,
            'name'  => 'Слайдер',
            'slug'  => 'slider',
            'image' => 'site-block-images/slider1.webp',
            'site_element_type_id' => 3,
        ]);

        SiteElementImage::query()
            ->insert([
                [
                    'site_element_id' => 4,
                    'image' => 'site-element-images/sliders/01KC4YANPRNAJBREYH9VT6GQKY.webp',
                ],
                [
                    'site_element_id' => 4,
                    'image' => 'site-element-images/sliders/01KC4YANQ55TAXRF8E3NH2V9D0.webp',
                ],
                [
                    'site_element_id' => 13,
                    'image' => 'site-element-images/sliders/a01.webp',
                ],
                [
                    'site_element_id' => 13,
                    'image' => 'site-element-images/sliders/a02.webp',
                ],
                [
                    'site_element_id' => 13,
                    'image' => 'site-element-images/sliders/a03.webp',
                ]
            ]);

        SiteElement::query()->create([
            'site_block_id'  => 4,
            'name'  => 'Контент',
            'slug'  => 'content',
            'site_element_type_id' => 5,
            'content' => '<p><strong>Список договоров, приложений и необходимых документов для сотрудничества с ООО &quot;АвтопартУнивекс&quot;</strong></p><ul><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на отгрузку со склада</u></p></li><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на доставку до склада Покупателя</u></p></li><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на доставку до транспортной компании  Покупателя</u></p></li><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на отгрузку со склада с отсрочкой платежа</u></p></li><li><p><a target="_blank" rel="noopener noreferrer nofollow" href="ya.ru"><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на доставку до склада Покупателя с отсрочкой платежа</u></a></p></li><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на доставку до транспортной компании  Покупателя с отсрочкой платежа</u></p></li><li><p><u>Приложение к договору 1,2</u></p></li><li><p><u>Приложение к договору 3,4</u></p></li><li><p><u>Список документов от Клиента, необходимых для заключения договора</u></p></li></ul><p><strong>Для того чтобы стать нашим клиентом и получить доступ ко всем сервисам нашего интернет-магазина, Вам необходимо пройти процесс регистрации в нашей базе. Для этого Вам нужно пройти по ссылке &quot;Регистрация&quot; в блоке <u>&quot;Вход для клиентов&quot;</u>.</strong></p>'
        ]);

        SiteElement::query()->create([
            'site_block_id'  => 5,
            'name'  => 'Договора',
            'slug'  => 'content',
            'site_element_type_id' => 5,
            'content' => '<p><strong>Список договоров, приложений и необходимых документов для сотрудничества с ООО &quot;АвтопартУнивекс&quot;:</strong></p><ul><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на отгрузку со склада</u></p></li><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на доставку до склада Покупателя</u></p></li><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на доставку до транспортной компании  Покупателя</u></p></li><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на отгрузку со склада с отсрочкой платежа</u></p></li><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на доставку до склада Покупателя с отсрочкой платежа</u></p></li><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на доставку до транспортной компании  Покупателя с отсрочкой платежа</u></p></li><li><p><u>Приложение к договору 1,2</u></p></li><li><p><u>Приложение к договору 3,4</u></p></li></ul><p><strong>Список документов от Клиента, необходимых для заключения договора:</strong></p><ul><li><p>Свидетельство о государственной регистрации (копия)</p></li><li><p>Свидетельство о постановке на учет в налоговом органе (ИНН) – копия</p></li><li><p>Фактический и юридический адреса (с индексом)</p></li><li><p>Почтовый адрес, если он является другим</p></li><li><p>Контактные телефоны, электронная почта, факс</p></li><li><p>Банковские реквизиты</p></li><li><p>Ф.И.О. Руководителя</p></li><li><p>Копия приказа о вступлении в должность руководителя c образцом подписи либо копия паспорта</p></li><li><p>Лист записи Единого государственного реестра индивидуальных предпринимателей</p></li><li><p>Код ОКТМО</p></li></ul><p><strong>Примечание:<br>В случае изменения любого из вышеперечисленных реквизитов необходимо направить в наш адрес информационное письмо (подписанное руководителем и с печатью организации) с  обязательным указанием даты изменения и новыми реквизитами.</strong></p>'
        ]);

        SiteElement::query()->create([
            'site_block_id'  => 6,
            'name'  => 'Претензии и возвраты',
            'slug'  => 'content',
            'site_element_type_id' => 5,
            'content' => '<p><strong>Список договоров, приложений и необходимых документов для сотрудничества с ООО &quot;АвтопартУнивекс&quot;:</strong></p><ul><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на отгрузку со склада</u></p></li><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на доставку до склада Покупателя</u></p></li><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на доставку до транспортной компании  Покупателя</u></p></li><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на отгрузку со склада с отсрочкой платежа</u></p></li><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на доставку до склада Покупателя с отсрочкой платежа</u></p></li><li><p><u>Договор с компанией ООО &quot;АвтопартУнивекс&quot; на доставку до транспортной компании  Покупателя с отсрочкой платежа</u></p></li><li><p><u>Приложение к договору 1,2</u></p></li><li><p><u>Приложение к договору 3,4</u></p></li></ul><p><strong>Список документов от Клиента, необходимых для заключения договора:</strong></p><ul><li><p>Свидетельство о государственной регистрации (копия)</p></li><li><p>Свидетельство о постановке на учет в налоговом органе (ИНН) – копия</p></li><li><p>Фактический и юридический адреса (с индексом)</p></li><li><p>Почтовый адрес, если он является другим</p></li><li><p>Контактные телефоны, электронная почта, факс</p></li><li><p>Банковские реквизиты</p></li><li><p>Ф.И.О. Руководителя</p></li><li><p>Копия приказа о вступлении в должность руководителя c образцом подписи либо копия паспорта</p></li><li><p>Лист записи Единого государственного реестра индивидуальных предпринимателей</p></li><li><p>Код ОКТМО</p></li></ul><p><strong>Примечание:<br>В случае изменения любого из вышеперечисленных реквизитов необходимо направить в наш адрес информационное письмо (подписанное руководителем и с печатью организации) с  обязательным указанием даты изменения и новыми реквизитами.</strong></p>'
        ]);

        SiteElement::query()->create([
            'site_block_id'  => 7,
            'name'  => 'Доставка',
            'slug'  => 'content',
            'site_element_type_id' => 5,
            'content' => '<p>Mы осуществляем доставку товара по Москве, Московской области, до терминалов транспортных компаний и по индивидуальным маршрутам </p><p>Доставка осуществляется на следующий день если заказ размещен до 16:00 и через день, если заказ размещен после 16:00</p><p>Заказы от 5 000 руб. доставляются по Москве и до транспортных компаний бесплатно.</p><p>Стоимость доставки заказа менее 5 000 руб. составляет 300 рублей</p><p>Услуги третьих лиц (грузчиков, въезд на ТК, стоянка) оплачиваются клиентом</p><p>Условия транспортных компаний по работе с хрупким и негабаритным грузом уточняйте непосредственно в выбранной компании при этом следует учитывать, что при отказе от обрешетки транспортные компании снимают с себя ответственность за целостность груза. Однако обрешетка груза приводит к удорожанию и задержкам при отправке, поэтому при передаче груза транспортной компании Унивекс не заказывает обрешетку, если это не оговорено клиентом в комментариях к заказу</p><p><strong>Вопросы связанные с доставкой вы можете обсудить с Дмитрием Царевым</strong></p><ul><li><p>Тел. +7 (910) 441-83-69</p></li><li><p>E-mail: <a target="_blank" rel="noopener noreferrer nofollow" href="mailto:tdv@univex.ru">tdv@univex.ru</a> </p></li></ul><table><tbody><tr><td rowspan="1" colspan="2"><p><strong>Условия доставки по рабочим дням - на следующий день при заказе до 16-00 </strong></p></td></tr><tr><td rowspan="1" colspan="2"><p> </p></td></tr><tr><td rowspan="1" colspan="1"><p><strong><u>Название компании</u></strong></p></td><td rowspan="1" colspan="1"><p><strong><u>Примечание</u></strong></p></td></tr><tr><td rowspan="1" colspan="1"><p>Деловые линии</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.dellin.ru">http://www.dellin.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>КИТ</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.tk-kit.ru">http://www.tk-kit.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>Байкал-Сервис</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.baikalsr.ru">http://www.baikalsr.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>УралТрансСервис</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.gr-ural.ru">http://www.gr-ural.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>ПЭК</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.pecom.ru">http://www.pecom.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>ЦАП</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.avtotransit.ru">http://www.avtotransit.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>ШЕРЛ</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.sherl.ru">http://www.sherl.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>ЖелДорЭкспедиция</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.jde.ru">http://www.jde.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>Главдоставка</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.glav-dostavka.ru">http://www.glav-dostavka.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>Фастранс</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.fastrans.ru">http://www.fastrans.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>Ратэк</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.rateksib.ru">http://www.rateksib.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p> </p></td><td rowspan="1" colspan="1"><p> </p></td></tr><tr><td rowspan="1" colspan="2"><p><strong>Доставка по Москве и  Московской области</strong></p></td></tr><tr><td rowspan="1" colspan="1"><p>Владимир - Нижний Новгород</p></td><td rowspan="1" colspan="1"><p>Четверг</p></td></tr><tr><td rowspan="1" colspan="1"><p>Ярославль - Кострома</p></td><td rowspan="1" colspan="1"><p>Пятница</p></td></tr><tr><td rowspan="1" colspan="1"><p>Воронеж - Липецк - Тула - Елец - Ефремов </p></td><td rowspan="1" colspan="1"><p>Вторник</p></td></tr><tr><td rowspan="1" colspan="1"><p>Тверь</p></td><td rowspan="1" colspan="1"><p>Понедельник</p></td></tr><tr><td rowspan="1" colspan="2"><p><strong>Возможна авиадоставка Вашего груза</strong></p></td></tr><tr><td rowspan="1" colspan="1"><p>ООО &quot;Альфа-Сервис&quot;</p></td><td rowspan="1" colspan="1"><p>По рабочим дням   <a target="_blank" rel="noopener noreferrer nofollow" href="http://alfaservis-air.ru">http://alfaservis-air.r</a></p></td></tr></tbody></table>'
        ]);

        SiteElement::query()->create([
            'site_block_id'  => 8,
            'name'  => 'Как стать поставщиком',
            'slug'  => 'content',
            'site_element_type_id' => 5,
            'content' => '<p>Mы осуществляем доставку товара по Москве, Московской области, до терминалов транспортных компаний и по индивидуальным маршрутам </p><p>Доставка осуществляется на следующий день если заказ размещен до 16:00 и через день, если заказ размещен после 16:00</p><p>Заказы от 5 000 руб. доставляются по Москве и до транспортных компаний бесплатно.</p><p>Стоимость доставки заказа менее 5 000 руб. составляет 300 рублей</p><p>Услуги третьих лиц (грузчиков, въезд на ТК, стоянка) оплачиваются клиентом</p><p>Условия транспортных компаний по работе с хрупким и негабаритным грузом уточняйте непосредственно в выбранной компании при этом следует учитывать, что при отказе от обрешетки транспортные компании снимают с себя ответственность за целостность груза. Однако обрешетка груза приводит к удорожанию и задержкам при отправке, поэтому при передаче груза транспортной компании Унивекс не заказывает обрешетку, если это не оговорено клиентом в комментариях к заказу</p><p><strong>Вопросы связанные с доставкой вы можете обсудить с Дмитрием Царевым</strong></p><ul><li><p>Тел. +7 (910) 441-83-69</p></li><li><p>E-mail: <a target="_blank" rel="noopener noreferrer nofollow" href="mailto:tdv@univex.ru">tdv@univex.ru</a> </p></li></ul><table><tbody><tr><td rowspan="1" colspan="2"><p><strong>Условия доставки по рабочим дням - на следующий день при заказе до 16-00 </strong></p></td></tr><tr><td rowspan="1" colspan="2"><p> </p></td></tr><tr><td rowspan="1" colspan="1"><p><strong><u>Название компании</u></strong></p></td><td rowspan="1" colspan="1"><p><strong><u>Примечание</u></strong></p></td></tr><tr><td rowspan="1" colspan="1"><p>Деловые линии</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.dellin.ru">http://www.dellin.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>КИТ</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.tk-kit.ru">http://www.tk-kit.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>Байкал-Сервис</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.baikalsr.ru">http://www.baikalsr.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>УралТрансСервис</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.gr-ural.ru">http://www.gr-ural.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>ПЭК</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.pecom.ru">http://www.pecom.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>ЦАП</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.avtotransit.ru">http://www.avtotransit.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>ШЕРЛ</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.sherl.ru">http://www.sherl.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>ЖелДорЭкспедиция</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.jde.ru">http://www.jde.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>Главдоставка</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.glav-dostavka.ru">http://www.glav-dostavka.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>Фастранс</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.fastrans.ru">http://www.fastrans.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p>Ратэк</p></td><td rowspan="1" colspan="1"><p><a target="_blank" rel="noopener noreferrer nofollow" href="http://www.rateksib.ru">http://www.rateksib.ru</a></p></td></tr><tr><td rowspan="1" colspan="1"><p> </p></td><td rowspan="1" colspan="1"><p> </p></td></tr><tr><td rowspan="1" colspan="2"><p><strong>Доставка по Москве и  Московской области</strong></p></td></tr><tr><td rowspan="1" colspan="1"><p>Владимир - Нижний Новгород</p></td><td rowspan="1" colspan="1"><p>Четверг</p></td></tr><tr><td rowspan="1" colspan="1"><p>Ярославль - Кострома</p></td><td rowspan="1" colspan="1"><p>Пятница</p></td></tr><tr><td rowspan="1" colspan="1"><p>Воронеж - Липецк - Тула - Елец - Ефремов </p></td><td rowspan="1" colspan="1"><p>Вторник</p></td></tr><tr><td rowspan="1" colspan="1"><p>Тверь</p></td><td rowspan="1" colspan="1"><p>Понедельник</p></td></tr><tr><td rowspan="1" colspan="2"><p><strong>Возможна авиадоставка Вашего груза</strong></p></td></tr><tr><td rowspan="1" colspan="1"><p>ООО &quot;Альфа-Сервис&quot;</p></td><td rowspan="1" colspan="1"><p>По рабочим дням   <a target="_blank" rel="noopener noreferrer nofollow" href="http://alfaservis-air.ru">http://alfaservis-air.r</a></p></td></tr></tbody></table>'
        ]);

        SiteElement::query()->create([
            'site_block_id'  => 3,
            'name' => 'Слайдер',
            'slug' => 'slider-footer-banners',
            'site_element_type_id' => 3,
        ]);

        SiteElementImage::query()->insert([
            [
                'site_element_id'  => 10,
                'image' => 'site-element-images/sliders/os1.webp'
            ],
            [
                'site_element_id'  => 10,
                'image' => 'site-element-images/sliders/os2.webp'
            ],
            [
                'site_element_id'  => 15,
                'image' => 'site-element-images/sliders/os1.webp'
            ],
            [
                'site_element_id'  => 15,
                'image' => 'site-element-images/sliders/os2.webp'
            ]
        ]);

        SiteElement::query()->create([
            'site_block_id'  => 9,
            'name' => 'Политика конфиденциальности',
            'slug' => 'privacy-policy',
            'site_element_type_id' => 2,
            'content' => 'Политика конфиденциальности',
        ]);

        SiteElement::query()->create([
            'site_block_id'  => 10,
            'name' => 'текст о компании',
            'slug' => 'about-text-up',
            'site_element_type_id' => 5,
            'content' => '<p>Компания «АвтопартУнивекс» работает на российском рынке с 1994 года и за это время зарекомендовала себя как надежный поставщик запасных частей для коммерческого транспорта. Наш опыт и партнерские связи позволяют нам обеспечивать клиентов продукцией, соответствующей самым высоким стандартам качества. Сегодня «АвтопартУнивекс» является официальным дилером ведущих мировых брендов:<br><strong>GIGANT, ТОНАР, BLACKTECH, PARLOK, FAD, TAS, LEMFÖRDER, ONYARBI, OPTIBELT, OREX, PENTA, POMMIER/FURGOCAR, SACHS, WABCO, WISTRA, ZF.</strong></p><p>Мы ценим доверие наших партнеров и предлагаем проверенные решения для стабильной работы автопарков и производственных предприятий.<br>«АвтопартУнивекс» — надежный поставщик, проверенный временем.</p>',
        ]);

        SiteElement::query()->create([
            'site_block_id'  => 11,
            'name' => 'Слайдер о компании',
            'slug' => 'about-slider',
            'site_element_type_id' => 3,
        ]);

        SiteElement::query()->create([
            'site_block_id'  => 13,
            'name' => 'Слайдер с офисом',
            'slug' => 'about-slider-footer-banners',
            'site_element_type_id' => 3,
        ]);

        SiteElement::query()->create([
            'site_block_id'  => 12,
            'name' => 'Текст карточки',
            'slug' => 'about-text-cards-left',
            'site_element_type_id' => 2,
            'content' => 'Поставка импортных комплектующих российским производителям коммерческих транспортных средст'
        ]);

        SiteElement::query()->create([
            'site_block_id'  => 12,
            'name' => 'Текст карточки',
            'slug' => 'about-text-cards-center',
            'site_element_type_id' => 2,
            'content' => 'Продажа запасных частей для прицепов с осями ТОНАР, BPW, SAF, ROR, GIGANT, FRUEHAUF, SMB, TRAILOR, L1'
        ]);

        SiteElement::query()->create([
            'site_block_id'  => 12,
            'name' => 'Текст карточки',
            'slug' => 'about-text-cards-right',
            'site_element_type_id' => 2,
            'content' => 'Продажа запасных частей для грузовиков MAN, MERCEDES, DAF, IVECO, RENAULT, SCANIA, VOLVO'
        ]);
    }
}
