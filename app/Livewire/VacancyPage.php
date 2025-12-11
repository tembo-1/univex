<?php

namespace App\Livewire;

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
        return view('livewire.vacancy-page');
    }
}
