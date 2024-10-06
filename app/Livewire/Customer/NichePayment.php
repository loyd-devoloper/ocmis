<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class NichePayment extends Component
{
    public $niche = [];

    public function mount($niche_id)
    {
        $niche = \App\Models\Niche::with('buildingInfo')->where("id", $niche_id)->first();
        $this->niche = $niche;

    }
    public function render()
    {
        return view('livewire.customer.niche-payment');
    }
}
