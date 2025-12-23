<?php

namespace App\Livewire\Pages\Single;

use App\Models\ContactGroup;
use Livewire\Component;

class ContactPage extends Component
{
    public $contactGroups;

    public function mount()
    {
        $this->contactGroups = ContactGroup::with('contacts')->get();
        $this->addBreadcrumbs();
    }
    public function render()
    {
        return view('livewire.pages.single.contact-page');
    }

    public function addBreadcrumbs(): void
    {
        $this->dispatch('updateBreadcrumbs',
            items: [
                [
                    'label' => 'Контакты',
                    'active' => true
                ],
            ]
        );
    }
}
