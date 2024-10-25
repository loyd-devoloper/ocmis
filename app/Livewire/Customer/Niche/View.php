<?php

namespace App\Livewire\Customer\Niche;

use Carbon\Carbon;

use Livewire\Component;
use Filament\Actions\Action;
use Jubaer\Zoom\Facades\Zoom;
use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Luigel\Paymongo\Facades\Paymongo;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;

class View extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;
    public $niche_id;
    public $nicheInfo = null;
    public $information = null;
    public $lname = '';
    public function mount($id)
    {
        $this->niche_id = $id;
        $this->nicheInfo = \App\Models\Niche::with('buildingInfo')->where('id',$id)->first();

    }
    public function modalFormAction()
    {
        return Action::make('modalForm')

            ->label('Update')
            ->color(Color::hex('#212529'))

            ->form([
                TextInput::make('lname')->label('Last name')->required()->default($this->information?->lname),
                Textarea::make('fname')->label('First Name')->required()->default($this->information?->fname),
                DatePicker::make('birthdate')->required()->default($this->information?->birthdate),
                DatePicker::make('deathdate')->required()->default($this->information?->deathdate),
                Textarea::make('message')->required()->default($this->information?->lname),
                FileUpload::make('image')->image()->required()->default($this->information?->image)
            ])
            ->action(function ($data) {
               \App\Models\NicheOwner::updateOrInsert([
                'niche_id'=>$this->niche_id,
                'customer_id'=>Auth::id(),
               ],$data);
                Notification::make()
                    ->title('Updated successfully')
                    ->success()
                    ->send();
            })
            ;
    }
    public function render()
    {
        $info = \App\Models\NicheOwner::where('niche_id',$this->niche_id)->where('customer_id',Auth::id())->first();
        $this->information = $info;


        return view('livewire.customer.niche.view',compact('info'));
    }
}
