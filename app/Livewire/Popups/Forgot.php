<?php

namespace App\Livewire\Popups;

use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;

class Forgot extends Component
{
    public $email;

    public function submit()
    {
        $this->validate([
            'email' => 'required|email|max:100',
        ], [
            'email.required' => 'Email обязателен',
            'email.email' => 'Введите корректный email адрес',
        ]);

        $key = 'forgot:' . request()->ip();
        $maxAttempts = 1;
        $decaySeconds = 60;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            $this->dispatch('showToast',
                type: 'error',
                message: "Лимит: 1 запросов в 30 минут. Следующий через {$seconds} сек."
            );
            return;
        }

        RateLimiter::hit($key, $decaySeconds);

        $user = User::query()
            ->firstWhere('email', $this->email);

        if (!$user) {
            $this->dispatch('showToast',
                type: 'error',
                message: "Нет клиента с такой почтой !"
            );
        }

        if (!$user->hasRole('Клиент')) {
            $this->dispatch('showToast',
                type: 'error',
                message: "Нет клиента с такой почтой !"
            );
        }

        $password = Str::password(12);

        $user
            ->update([
                'password' => $password
            ]);
    }

    public function render()
    {
        return view('components.popups.forgot');
    }
}
