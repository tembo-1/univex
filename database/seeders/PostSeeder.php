<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::query()->truncate();

        Post::query()
            ->insert([
                [
                    'title'         => 'На склад поступили тормозные камеры и энергоаккумуляторы OREX',
                    'slug'          => Str::slug('На склад поступили тормозные камеры и энергоаккумуляторы OREX'),
                    'image'         => 'posts/01.webp',
                    'content'       => 'test',
                    'is_visible'    => 1,
                    'position'      => 1,
                    'is_published'  => 1,
                ],
                [
                    'title'         => 'На склад поступили запасные части Co.Par (Италия) - крылья, брызговики, инструментальные ящики, бамперы прицепа и пр.',
                    'slug'          => Str::slug('На склад поступили запасные части Co.Par (Италия) - крылья, брызговики, инструментальные ящики, бамперы прицепа и пр.'),
                    'image'         => 'posts/02.webp',
                    'content'       => 'test',
                    'is_visible'    => 1,
                    'position'      => 1,
                    'is_published'  => 1,
                ],
                [
                    'title'         => 'Новинки в ассортименте ТМР — отечественного производителя качественных автокомпонентов из первичного пластика',
                    'slug'          => Str::slug('Новинки в ассортименте ТМР — отечественного производителя качественных автокомпонентов из первичного пластика'),
                    'image'         => 'posts/03.webp',
                    'content'       => 'test',
                    'is_visible'    => 1,
                    'position'      => 1,
                    'is_published'  => 1,
                ],
                [
                    'title'         => 'На складе в наличии шкворни полуприцепа 2" и 3,5"',
                    'slug'          => Str::slug('На складе в наличии шкворни полуприцепа 2" и 3,5"'),
                    'image'         => 'posts/05.webp',
                    'content'       => 'test',
                    'is_visible'    => 1,
                    'position'      => 1,
                    'is_published'  => 1,
                ],
                [
                    'title'         => 'Предлагаем с нашего склада оригинальный SACHS',
                    'slug'          => Str::slug('Предлагаем с нашего склада оригинальный SACHS'),
                    'image'         => 'posts/06.webp',
                    'content'       => 'test',
                    'is_visible'    => 1,
                    'position'      => 1,
                    'is_published'  => 1,
                ],
                [
                    'title'         => 'Информируем об очередном поступлении на склад оригинальной продукции WABCO',
                    'slug'          => Str::slug('Информируем об очередном поступлении на склад оригинальной продукции WABCO'),
                    'image'         => 'posts/07.webp',
                    'content'       => 'test',
                    'is_visible'    => 1,
                    'position'      => 1,
                    'is_published'  => 1,
                ],
                [
                    'title'         => 'Под праздник на склад поступили запасные части GIGANT',
                    'slug'          => Str::slug('Под праздник на склад поступили запасные части GIGANT'),
                    'image'         => 'posts/08.webp',
                    'content'       => 'test',
                    'is_visible'    => 1,
                    'position'      => 1,
                    'is_published'  => 1,
                ],

            ]);
    }
}
