<?php

namespace App\Livewire\Customer;

use Carbon\Carbon;

use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use function Filament\Support\format_number;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Concerns\InteractsWithForms;

class NichePayment extends Component implements HasForms
{
    use InteractsWithForms;
    public $niche = [];
    public $niche_id = '';
    public $newPrice = 0;
    public $perMonth = 0;
    public $downpayment = 10000;
    public $payment_method = 'Full';




    // services
    public $service = [];
    public $schedules = [];
    public $priests = [];

    public $own_priest = false;
    public $date;
    public $priest_id;
    public $message;
    public $deceasedname;
    public $schedule;
    public $service_id;

    public $serviceArr = [];
    public $productArr = [];

    public function mount($niche_id)
    {
        $this->niche_id = $niche_id;
        $niche = \App\Models\Niche::with('buildingInfo')->where("id", $niche_id)->first();
        $this->newPrice = (float)$niche->price + (2.5 / 100 * (float)$niche->price);

        $this->perMonth = ($this->newPrice - $this->downpayment) / 3;

        $this->niche = $niche;

        // $this->payment_method = $type;
        // $this->niche_id = $niche_id;
        // $niche = \App\Models\Niche::with('buildingInfo')->where("id", $niche_id)->first();
        // $this->newPrice = (float)$niche->price + (2.5 / 100 * (float)$niche->price);

        // $this->perMonth = ($this->newPrice - $this->downpayment) / 3;

        $this->niche = $niche;

        // services
        // $this->service_id = 1;
        // $x = \App\Models\Category::where('id', 1)->first();
        // $this->service = $x;
        $this->schedules = \App\Models\PriestSchedule::where('status', 0)->whereDate('date','>', Carbon::now())->get();
        $this->priests = \App\Models\Priest::where('status', 'Active')->get();


    }
    public function changeQuantitys($type,$ShopProduct)
    {
        $x = \App\Models\ShopProduct::where('id',$ShopProduct)->first();


         $x->update([
             'quantity'=> $type == 'plus' ? (int)$x?->quantity - 1 : (int)$x?->quantity + 1
          ]);


    }
    public function changeQuantity($id)
    {
        $first =  \App\Models\ShopProduct::where('id',$id)->first();
        $first->update([
            'quantity' => (int)$first->quantity - 1
        ]);

    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DateTimePicker::make('date_time') ->minDate(Carbon::now()->addDay(3))->required()->statePath('date')->label(false)->nullable(),

                // ...
            ])
            ;
    }
    public function render()
    {

        $aLLServices = \App\Models\Category::get();
        $serviceArray = $this->serviceArr;
        $products = \App\Models\ShopProduct::with('categoryInfo')->get();
        return view('livewire.customer.niche-payment',compact('aLLServices','serviceArray','products'));
    }
}
