<?php

namespace App\Livewire\Auth;

use App\Models\LoginLog;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginForm extends Component
{
    public $email = '';
    public $password = '';
    public $error = '';
    public $success = false;

    public function submit()
    {

        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password
        ]) ) {
            try {
                $info = geoip(request()->ip());

                LoginLog::query()
                    ->create([
                        'user_id' => auth()->id(),
                        'ip_address' => request()->ip(),
                        'country' => $info->country,
                        'city' => $info->city,
                    ]);

                redirect(url()->previous());
            } catch (\Throwable) {
                redirect(url()->previous());
            }
        } else {
            $this->error = 'Неверный email или пароль';
        }
    }

    public function render()
    {
        return view('livewire.auth.login-form');
    }
}
