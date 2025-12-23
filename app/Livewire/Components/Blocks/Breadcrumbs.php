<?php

namespace App\Livewire\Components\Blocks;

use Illuminate\Support\Collection;
use Livewire\Component;

class Breadcrumbs extends Component
{
    public Collection $items;
    public bool $show = false;

    protected $listeners = [
        'updateBreadcrumbs' => 'updateItems',
        'addBreadcrumb' => 'addItem',
        'clearBreadcrumbs' => 'clearItems',
        'showBreadcrumbs' => 'show',
    ];

    public function mount()
    {
        $this->items = collect([
            [
                'label' => 'Главная',
                'url' => route('home'),
                'active' => false,
            ]
        ]);
    }

    public function updateItems(array $items)
    {
        $this->items = $this->items->take(1);

        foreach ($items as $item) {
            $this->items->push([
                'label' => $item['label'] ?? '',
                'url' => $item['url'] ?? 'javascript:void(0)',
                'active' => $item['active'] ?? false,
            ]);
        }

        $this->show();
    }

    public function show()
    {
        $this->show = true;
    }

    public function addItem(string $label, string $url = 'javascript:void(0)', bool $active = false)
    {
        $this->items->push([
            'label' => $label,
            'url' => $url,
            'active' => $active,
        ]);
    }

    public function clearItems()
    {
        $this->items = collect([
            [
                'label' => 'Главная',
                'url' => route('home'),
                'active' => false,
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.components.blocks.breadcrumbs');
    }
}
