<?php

namespace App\Livewire\Customer;

use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;

use Livewire\Component;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Jubaer\Zoom\Facades\Zoom;
use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Luigel\Paymongo\Facades\Paymongo;
use Filament\Forms\Components\Section;

use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;

use Filament\Forms\Components\TextInput;

use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Contracts\HasActions;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;


class Setting extends Component implements HasActions, HasForms
{
    use InteractsWithForms;
    use InteractsWithActions;
    use InteractsWithForms;
    public ?array $data = [
        'fname' => '',
        'mname' => '',
        'lname' => '',
        'email' => '',
        'address' => '',
        'contact' => ''
    ];



    public function modalFormAction()
    {
        return Action::make('modalForm')
            ->label('Change Password')
            ->color(Color::Red)
            ->form([
                TextInput::make('password')
                ->label('Password')
                ->password()
                ->required()
                ->minLength(8) // Minimum length for password
                ->maxLength(255) // Maximum length for password
                ->rules('confirmed'), // This will enforce confirmation

            TextInput::make('password_confirmation')
                ->label('Confirm Password')
                ->password()
                ->required()
                ->minLength(8) // Minimum length for confirmation
                ->maxLength(255),

            ])
            ->action(function ($data) {
                User::where('id',Auth::id())->update(['password'=>Hash::make($data['password'])]);
                Notification::make()
                    ->title('Updated successfully')
                    ->success()
                    ->send();
            })->extraAttributes(['class'=>'w-full']);
    }
    public function mount(): void
    {
        $this->form->fill([
            'fname'=>Auth::user()->fname,
            'lname'=>Auth::user()->lname,
            'mname'=>Auth::user()->mname,
            'email'=>Auth::user()->email,
            'address'=>Auth::user()->address,
            'contact'=>Auth::user()->contact,
        ]);
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('fname')->label('First Name'),
                TextInput::make('mname')->label('Middle Name'),
                TextInput::make('lname')->label('Last Name'),
                TextInput::make('email'),
                TextInput::make('address'),
                TextInput::make('contact')->label('Contact Number'),
            ]) ->statePath('data');;
    }

    public function update()
    {
        User::where('id',Auth::id())->update($this->data);
        Notification::make()
        ->title('Updated successfully')
        ->success()
        ->send();
        return redirect()->route('customer.setting');
    }


    public function render(): View
    {
        return view('livewire.customer.setting');
    }
}
