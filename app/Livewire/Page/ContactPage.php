<?php

namespace App\Livewire\Page;

use App\Models\ContactGroup;
use Livewire\Component;

class ContactPage extends Component
{
    public $contactGroups;

    public function mount()
    {
        $this->contactGroups = ContactGroup::with('contacts')->get();
    }
    public function render()
    {
        return view('livewire.page.contact-page');
    }
}
