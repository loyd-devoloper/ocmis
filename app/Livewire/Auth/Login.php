<?php

namespace App\Livewire\Auth;

use App\Models\User;
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
            "username" => ["required"],
            "password" => ["required"],
        ]);
        if (Auth::attempt($validate)) {
            if (Auth::user()->role == 'admin') {

                $this->redirectRoute('admin.users');
            } else {

                if (!!Auth::user()->email_verified_at) {
                  return redirect()->route('home');

                }
                Auth::logout();
                Notification::make()
                    ->title('Your email is not verified.')
                    ->danger()
                    ->persistent()
                    ->send();
            }
        } else {
            Notification::make()
                ->title('Wrong Credential')
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
