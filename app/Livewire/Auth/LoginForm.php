<?php

namespace App\Livewire\Auth;

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
            redirect(url()->previous());
        } else {
            $this->error = 'Неверный email или пароль';
        }
    }

    public function render()
    {
        return view('livewire.auth.login-form');
    }
}
