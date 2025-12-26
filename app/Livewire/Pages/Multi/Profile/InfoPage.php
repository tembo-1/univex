<?php

namespace App\Livewire\Pages\Multi\Profile;

use App\Models\Employee;
use Livewire\Component;

class InfoPage extends Component
{
    public Employee $manager;
    public $inn;
    public $name;
    public $shortName;
    public $kpp;
    public $ogrn;
    public $legalAddress;
    public $postalAddress;
    public $headName;
    public $headPosition;
    public $bankName;
    public $bik;
    public $paymentAccount;
    public $correspondentAccount;
    public $edoIdentifier;
    public $edoOperator;
    public $firstName;
    public $lastName;
    public $middleName;
    public $phone;
    public $email;


    public function mount()
    {
        $user = auth()->user();
        $client = $user->client;

        $this->manager = $client->employee;
        $this->inn = $client->inn;

        // Заполняем реквизиты организации
        $this->name = $client->name ?? '';
        $this->shortName = $client->short_name ?? '';
        $this->kpp = $client->kpp ?? '';
        $this->ogrn = $client->ogrn ?? '';
        $this->legalAddress = $client->legal_address ?? '';
        $this->postalAddress = $client->postal_address ?? '';
        $this->headName = $client->head_name ?? '';
        $this->headPosition = $client->head_position ?? '';

        // Банковские реквизиты
        $this->bankName = $client->bankAccount->bank_name ?? '';
        $this->bik = $client->bankAccount->bik ?? '';
        $this->paymentAccount = $client->bankAccount->payment_account ?? '';
        $this->correspondentAccount = $client->bankAccount->correspondent_account ?? '';

        // ЭДО
        $this->edoIdentifier = $client->edo_identifier ?? '';
        $this->edoOperator = $client->edo_operator ?? '';

        // Личные данные (из профиля пользователя или сотрудника)
        $this->firstName = $user->client->client->first_name ?? '';
        $this->lastName = $user->client->last_name ?? '';
        $this->middleName = $user->client->middle_name ?? '';
        $this->phone = $user->client->phone ?? '';
        $this->email = $user->email ?? '';

        $this->addBreadcrumbs();
    }

    public function render()
    {
        return view('livewire.pages.multi.profile.info-page');
    }

    public function addBreadcrumbs(): void
    {
        $this->dispatch('updateBreadcrumbs',
            items: [
                [
                    'label' => 'Личный кабинет',
                    'url'   => route('cabinet'),
                    'active' => false
                ],
                [
                    'label' => 'Данные профиля',
                    'active' => true
                ],
            ]
        );
    }
}
