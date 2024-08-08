<?php

namespace App\Filament\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as AuthLogin;

class Login extends AuthLogin
{
    public function mount(): void
    {
        parent::mount();

        if(app()->environment('local')) {
            $this->form->fill([
                'email' => 'test@example.com',
                'password' => 'password',
                'remember' => true
            ]);
        }
    }
}