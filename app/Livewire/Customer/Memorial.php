<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Filament\Actions\Action;
use Livewire\Attributes\Title;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;

class Memorial extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public function modalFormAction()
    {
        return Action::make('modalForm')
        ->form([
            Select::make('authorId')
            ->label('Author')
            ->required(),
        ])
            ->action(function($data){
                dd($data);
            });
    }

    #[Title('Memorial')]
    public function render()
    {
        return view('livewire.customer.memorial');
    }
}
