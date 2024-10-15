<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;

class Register extends Component
{

    public $fname;
    public $lname;
    public $mname;
    public $address;
    public $contact;
    public $username;
    public $email;
    public $password;
    public $password_confirmation;
    public $role;
    public function register()
    {

        $validated = $this->validate([
            'fname'=>'required',
            'lname'=>'required',
            'address'=>'required',
            'username'=>'required',
            'contact'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required|confirmed|min:8',
            'password_confirmation'=>'required',
        ]);

        \App\Models\User::create([
            'fname'=>$this->fname,
            'lname'=>$this->lname,
            'mname'=>$this->mname,
            'address'=>$this->address,
            'username'=>$this->username,
            'contact'=>$this->contact,
            'email'=>$this->email,
            'password'=>Hash::make($this->password),

        ]);
        Notification::make()
        ->title( 'Created successfully')
        ->success()
        ->send();
        $this->reset();
    }
    public function render()
    {
        return view('livewire.auth.register');
    }
}
