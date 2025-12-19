<?php

namespace App\Livewire\Popups;

use App\Models\Callback;
use App\Models\CallbackType;
use Livewire\Component;

class CallbackPopup extends Component
{
    public string $name = '';
    public string $phone = '';
    public string $method = 'phone'; // Значение по умолчанию
    public string $privacy = '';
    public string $error = '';

    public function submit()
    {
        // Валидация
        $this->validate([
            'name' => 'required|min:2',
            'phone' => 'required|min:10',
            'method' => 'required|in:phone,telegram,whatsapp',
            'privacy' => 'required|accepted',
        ], [
            'name.required' => 'Введите ФИО',
            'phone.required' => 'Введите номер телефона',
            'method.required' => 'Выберите способ связи',
            'privacy.required' => 'Необходимо согласие с условиями',
            'privacy.accepted' => 'Необходимо согласие с условиями',
        ]);

        $callbackType = CallbackType::query()
            ->firstWhere('name', $this->method);

        Callback::query()->create([
            'name' => $this->name,
            'phone' => $this->phone,
            'callback_type_id' => $callbackType->id,
        ]);

        $this->dispatch('showToast',
            type: 'success',
            message: 'Скоро с Вами свяжется наш менеджер!'
        );

        $this->resetForm();
    }

    /**
     * Сброс формы
     */
    public function resetForm()
    {
        $this->reset(['name', 'phone', 'method', 'privacy', 'error']);
        $this->method = 'phone'; // Устанавливаем значение по умолчанию
    }

    /**
     * При изменении полей сбрасываем ошибку
     */
    public function updated($propertyName)
    {
        if ($propertyName !== 'error') {
            $this->error = '';
        }
    }

    public function render()
    {
        return view('components.popups.callback');
    }
}
