<?php

namespace App\Models;

use DOMDocument;
use DOMXPath;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class SiteElement extends Model
{
    protected $guarded = [];

    public function siteElementType(): BelongsTo
    {
        return $this->belongsTo(SiteElementType::class);
    }

    public function getImageUrlAttribute()
    {
        return Storage::disk('documents')
            ->url($this->image);
    }

    public function siteElementImages(): HasMany
    {
        return $this->hasMany(SiteElementImage::class);
    }

    public function getCleanContentAttribute(): string
    {
        $html = $this->content;

        $dom = new DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xpath = new DOMXPath($dom);
        $listItems = $xpath->query('//li');

        foreach ($listItems as $li) {
            $children = $li->childNodes;

            foreach ($children as $child) {
                if ($child->nodeName === 'p') {
                    while ($child->hasChildNodes()) {
                        $li->insertBefore($child->firstChild, $child);
                    }
                    $li->removeChild($child);
                }
            }
        }

        $paragraphs = $xpath->query('//p[not(node())]');
        foreach ($paragraphs as $p) {
            $p->parentNode->removeChild($p);
        }

        $ols = $xpath->query('//ol[@start="1"]');
        foreach ($ols as $ol) {
            $ol->removeAttribute('start');
        }

        $cleanHtml = $dom->saveHTML();

        $cleanHtml = str_replace(['<html lang="">', '</html>', '<body>', '</body>'], '', $cleanHtml);

        return trim($cleanHtml);
    }
}
