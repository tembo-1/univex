<?php

namespace App\Livewire\Pages\Single;

use App\Models\Vacancy;
use Livewire\Component;

class VacancyPage extends Component
{
    public $vacancies;

    public function mount()
    {
        $this->vacancies = Vacancy::all();
    }

    public function render()
    {
        return view('livewire.pages.single.vacancy-page');
    }
}
