<?php

namespace App\Filament\Resources\SitePages\Pages;

use App\Filament\Resources\SitePages\SitePageResource;
use App\Models\SiteBlock;
use App\Models\SiteElement;
use App\Models\SitePage;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateSitePage extends CreateRecord
{
    protected static string $resource = SitePageResource::class;

    protected function handleRecordCreation(array $data): Model
    {

            $page = DB::transaction(function () use ($data) {
                $page = SitePage::create([
                    'name' => $data['name'],
                    'slug' => $data['url'],
                    'url' => $data['url'],
                    'title' => $data['title'],
                    'meta_description' => $data['meta_description'],
                    'meta_keywords' => $data['meta_keywords'],
                ]);

                $blockData = $data['siteBlocks'][0];
                $block = SiteBlock::create([
                    'site_page_id' => $page->id,
                    'slug' => Str::slug($blockData['name']),
                    'name' => $blockData['name'],
                    'is_active' => 1,
                ]);

                // ✅ Теперь используем 'elements' вместо 'Элементы'
                $elementData = $blockData['elements'][0] ?? [];
                SiteElement::create([
                    'name' => $elementData['name'] ?? '',
                    'slug' => Str::slug($elementData['name'] ?? ''),
                    'content' => $elementData['content'] ?? '',
                    'site_block_id' => $block->id,
                    'site_element_type_id' => 5
                ]);

                return $page->fresh();
            });

            return $page;


    }
}
