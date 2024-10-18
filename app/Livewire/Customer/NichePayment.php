<?php

namespace App\Livewire\Customer;

use Livewire\Component;

use function Filament\Support\format_number;

class NichePayment extends Component
{
    public $niche = [];
    public $newPrice = 0;
    public $perMonth = 0;

    public function mount($niche_id)
    {
        $niche = \App\Models\Niche::with('buildingInfo')->where("id", $niche_id)->first();
        $this->newPrice = (float)$niche->price + (2.5 / 100 * (float)$niche->price);

        $this->perMonth = $this->newPrice / 3;

        $this->niche = $niche;

    }
    public function render()
    {
        return view('livewire.customer.niche-payment');
    }
}
