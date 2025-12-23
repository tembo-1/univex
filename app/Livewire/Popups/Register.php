<?php

namespace App\Livewire\Popups;

use App\Models\Client;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use MoveMoveIo\DaData\Enums\BranchType;
use MoveMoveIo\DaData\Enums\CompanyType;
use MoveMoveIo\DaData\Facades\DaDataCompany;

class Register extends Component
{
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
    public $privacyPolicy = false;

    public function searchByInn()
    {
        try {
            $inn = trim($this->inn);

            $key = 'dadata-search:' . request()->ip();

            if (empty($inn) or !preg_match('/^\d{10,12}$/', $inn)) {
                $this->dispatch('showToast',
                    type: 'error',
                    message: 'Некорректный инн'
                );
                return;
            }

            $dadata = RateLimiter::attempt(
                key: $key,
                maxAttempts: 5,
                callback: function () {
                    return DaDataCompany::id($this->inn, 1, null, BranchType::MAIN, CompanyType::LEGAL);
                },
                decaySeconds: 30
            );

            if ($dadata === false) {
                $seconds = RateLimiter::availableIn($key);
                $this->dispatch('showToast',
                    type: 'error',
                    message: "Лимит: 5 запроса в минуту. Следующий через $seconds сек."
                );
                return;
            }

            $info = data_get($dadata, 'suggestions');

            if (!empty($info)) {
                $this->name             = data_get($info, '0.data.name.full_with_opf');
                $this->shortName        = data_get($info, '0.data.name.short_with_opf');
                $this->kpp              = data_get($info, '0.data.kpp');
                $this->ogrn             = data_get($info, '0.data.ogrn');
                $this->legalAddress     = data_get($info, '0.data.address.value');
                $this->postalAddress    = data_get($info, '0.data.address.value');
                $this->headName         = data_get($info, '0.data.management.name');
                $this->headPosition     = data_get($info, '0.data.management.post');
            } else {
                $this->dispatch('showToast',
                    type: 'error',
                    message: "ИНН не найден!"
                );
            }

        } catch (\Throwable) {
            $this->dispatch('showToast',
                type: 'error',
                message: "Введите корректный ИНН или заполните данные вручную!"
            );
        }
    }

    public function submit()
    {
        $this->validate([
            // Основные реквизиты
            'inn' => 'required|digits:10,12|numeric',
            'name' => 'required|string|min:5|max:255',
            'shortName' => 'required|string|min:2|max:100',
            'kpp' => 'required|digits:9|numeric',
            'ogrn' => 'required|digits_between:13,15|numeric',
            'legalAddress' => 'required|string|min:10|max:500',
            'postalAddress' => 'required|string|min:10|max:500',

            // Руководство
            'headName' => 'required|string|min:5|max:150',
            'headPosition' => 'required|string|min:3|max:100',

            // Банковские реквизиты
            'bankName' => 'required|string|min:3|max:255',
            'bik' => 'required|digits:9|numeric',
            'paymentAccount' => 'required|digits:20|numeric',
            'correspondentAccount' => 'required|digits:20|numeric',

            // ЭДО
            'edoOperator' => 'required|string|min:2|max:100',
            'edoIdentifier' => 'required|string|min:5|max:100',

            // Контактное лицо
            'lastName' => 'required|string|min:2|max:50|regex:/^[а-яА-ЯёЁ\s\-]+$/u',
            'firstName' => 'required|string|min:2|max:50|regex:/^[а-яА-ЯёЁ\s\-]+$/u',
            'middleName' => 'nullable|string|min:2|max:50|regex:/^[а-яА-ЯёЁ\s\-]+$/u',
            'phone' => 'required|string|min:10|max:20|regex:/^[\d\s\-\+\(\)]+$/',
            'email' => 'required|email|max:100',

            // Согласие
            'privacyPolicy' => 'required|accepted',

        ], [
            // Основные реквизиты
            'inn.required' => 'ИНН обязателен для заполнения',
            'inn.digits' => 'ИНН должен содержать 10 или 12 цифр',
            'inn.numeric' => 'ИНН должен содержать только цифры',

            'name.required' => 'Полное наименование организации обязательно',
            'name.min' => 'Полное наименование должно содержать минимум 5 символов',

            'shortName.required' => 'Краткое наименование организации обязательно',
            'shortName.min' => 'Краткое наименование должно содержать минимум 2 символа',

            'kpp.required' => 'КПП обязателен для заполнения',
            'kpp.digits' => 'КПП должен содержать 9 цифр',

            'ogrn.required' => 'ОГРН обязателен для заполнения',
            'ogrn.digits_between' => 'ОГРН должен содержать 13 или 15 цифр',

            'legalAddress.required' => 'Юридический адрес обязателен',
            'legalAddress.min' => 'Юридический адрес должен содержать минимум 10 символов',

            'postalAddress.required' => 'Почтовый адрес обязателен',
            'postalAddress.min' => 'Почтовый адрес должен содержать минимум 10 символов',

            // Руководство
            'headName.required' => 'ФИО руководителя обязательно',
            'headName.min' => 'ФИО руководителя должно содержать минимум 5 символов',

            'headPosition.required' => 'Должность руководителя обязательна',
            'headPosition.min' => 'Должность должна содержать минимум 3 символа',

            // Банковские реквизиты
            'bankName.required' => 'Наименование банка обязательно',
            'bankName.min' => 'Наименование банка должно содержать минимум 3 символа',

            'bik.required' => 'БИК обязателен',
            'bik.digits' => 'БИК должен содержать 9 цифр',

            'paymentAccount.required' => 'Расчетный счет обязателен',
            'paymentAccount.digits' => 'Расчетный счет должен содержать 20 цифр',

            'correspondentAccount.required' => 'Корреспондентский счет обязателен',
            'correspondentAccount.digits' => 'Корреспондентский счет должен содержать 20 цифр',

            // ЭДО
            'edoOperator.required' => 'Оператор ЭДО обязателен',
            'edoOperator.min' => 'Название оператора должно содержать минимум 2 символа',

            'edoIdentifier.required' => 'Идентификатор ЭДО обязателен',
            'edoIdentifier.min' => 'Идентификатор должен содержать минимум 5 символов',

            // Контактное лицо
            'lastName.required' => 'Фамилия обязательна',
            'lastName.min' => 'Фамилия должна содержать минимум 2 символа',
            'lastName.regex' => 'Фамилия должна содержать только русские буквы',

            'firstName.required' => 'Имя обязательно',
            'firstName.min' => 'Имя должно содержать минимум 2 символа',
            'firstName.regex' => 'Имя должно содержать только русские буквы',

            'middleName.regex' => 'Отчество должно содержать только русские буквы',

            'phone.required' => 'Телефон обязателен',
            'phone.min' => 'Телефон должен содержать минимум 10 цифр',
            'phone.regex' => 'Введите корректный номер телефона',

            'email.required' => 'Email обязателен',
            'email.email' => 'Введите корректный email адрес',

            'privacyPolicy.required' => 'Необходимо согласие с обработкой персональных данных',
            'privacyPolicy.accepted' => 'Необходимо согласие с обработкой персональных данных',
        ]);

        $this->saveData();
    }

    private function saveData()
    {
        $data = [
            'inn' => $this->inn,
            'name' => $this->name,
            'short_name' => $this->shortName,
            'kpp' => $this->kpp,
            'ogrn' => $this->ogrn,
            'legal_address' => $this->legalAddress,
            'postal_address' => $this->postalAddress,
            'head_name' => $this->headName,
            'head_position' => $this->headPosition,
            'bank_name' => $this->bankName,
            'bik' => $this->bik,
            'payment_account' => $this->paymentAccount,
            'correspondent_account' => $this->correspondentAccount,
            'edo_operator' => $this->edoOperator,
            'edo_identifier' => $this->edoIdentifier,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'middle_name' => $this->middleName,
            'phone' => $this->phone,
            'email' => $this->email,
            'privacy_policy_accepted' => true,
            'accepted_at' => now(),
        ];
    }

    public function render()
    {
        return view('components.popups.register');
    }
}
