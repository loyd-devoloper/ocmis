<?php

namespace App\Livewire\Customer;

use Livewire\Component;

use function Filament\Support\format_number;

class NichePayment extends Component
{
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
        $this->schedules = \App\Models\PriestSchedule::where('status', 0)->get();
        $this->priests = \App\Models\Priest::where('status', 'Active')->get();


    }
    public function render()
    {
        $aLLServices = \App\Models\Category::get();
        $serviceArray = $this->serviceArr;
        $products = \App\Models\ShopProduct::with('categoryInfo')->get();
        return view('livewire.customer.niche-payment',compact('aLLServices','serviceArray','products'));
    }
}
