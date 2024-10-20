<?php

namespace App\Livewire\Customer\Niche;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Checkout extends Component
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
    public function mount($niche_id,$type)
    {
        $this->payment_method = $type;
        $this->niche_id = $niche_id;
        $niche = \App\Models\Niche::with('buildingInfo')->where("id", $niche_id)->first();
        $this->newPrice = (float)$niche->price + (2.5 / 100 * (float)$niche->price);

        $this->perMonth = ($this->newPrice - $this->downpayment) / 3;

        $this->niche = $niche;

        // services
        // $this->service_id = 1;
        // $x = \App\Models\Category::where('id', 1)->first();
        // $this->service = $x;
        $this->schedules = \App\Models\PriestSchedule::where('status', 0)->get();
        $this->priests = \App\Models\Priest::where('status', 'Active')->get();


    }

    public function removeService()
    {
        $this->serviceArr = [];
    }
    public function submit()
    {
          $x = \App\Models\Category::where('id', $this->service_id)->first();
        $this->serviceArr = [
            'own_priest' => $this->own_priest,
            'service_id' => $this->service_id,
            'user_id' => Auth::id(),
            'message' => $this->message,
            'deceasedname' => $this->deceasedname,
            'status' => \App\Enums\StatusEnum::NotPaid->value,
            'image' =>$x?->image,
            'name' =>$x?->name,
            'price' =>$x?->price,
        ];

        if ($this->own_priest) {
            $this->serviceArr['date'] =$this->date;
            $this->serviceArr['date_format'] = Carbon::parse($this->date)->format('F d, Y h:i:s A');

        } else {
            $priestInfo = \App\Models\Priest::where('id', $this->priest_id)->first();
            $schedule = \App\Models\PriestSchedule::where('id', $this->schedule)->first();
            $date = Carbon::parse($schedule->date)->format('F d, Y');
            $start = Carbon::parse($schedule->start_time)->format('h:i A');
            $end = Carbon::parse($schedule->end_time)->format('h:i A');
            $this->serviceArr['schedule_id'] = $this->schedule;
            $this->serviceArr['schedule_info'] ="$date $start TO $end";
            $this->serviceArr['priest_id'] = $this->priest_id;
            $this->serviceArr['priest_name'] = $priestInfo?->name;

        }



    }

    public function addToCart($product)
    {
        if (is_array($this->productArr)) {



        } else {

            $x = json_decode($this->productArr,true);
            $this->productArr = $x;

        }


        if (array_key_exists($product['id'], $this->productArr)) {
           $x =  $this->productArr[$product['id']];
            $x['quantitys'] = $x['quantitys'] + 1;
            $this->productArr[$product['id']] = $x;

        } else {
            $product['quantitys'] = 1;
            $this->productArr[$product['id']] = $product;

        }



    }
    public function render()
    {
        $aLLServices = \App\Models\Category::get();
        $serviceArray = $this->serviceArr;
        $products = \App\Models\ShopProduct::with('categoryInfo')->get();


        return view('livewire.customer.niche.checkout',compact('aLLServices','serviceArray','products'));
    }
}
