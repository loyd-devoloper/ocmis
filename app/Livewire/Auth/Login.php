<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;

class Login extends Component
{
    public $username;
    public $password;
    public function login()
    {
        $validate = $this->validate([
            "username"=> ["required"],
            "password"=> ["required"],
        ]);
        if(Auth::attempt($validate))
        {
          $this->redirectRoute('admin.users');
        }else{
            Notification::make()
            ->title( 'Wrong Credential')
            ->danger()
            ->send();
        }
    }
    #[Title("Login")]
    public function render()
    {

        return view('livewire.auth.login');
    }
}
