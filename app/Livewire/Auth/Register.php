<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

       $user = \App\Models\User::create([
            'fname'=>$this->fname,
            'lname'=>$this->lname,
            'mname'=>$this->mname,
            'address'=>$this->address,
            'username'=>$this->username,
            'contact'=>$this->contact,
            'email'=>$this->email,
            'password'=>Hash::make($this->password),

        ]);
        $link = 'https://ocmis.online/verified/'.$user->id;
        Mail::to($this->email)->send(new  \App\Mail\Verification($link));
        Notification::make()
        ->title( 'Check your email '.$this->email.' for the verification link.')
        ->persistent()
        ->success()
        ->send();
        return redirect()->route('login');
    }
    public function render()
    {
        return view('livewire.auth.register');
    }
}
