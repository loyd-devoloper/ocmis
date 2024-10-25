<?php

namespace App\Livewire\Admin\Forecast;

use Livewire\Component;

class Niche extends Component
{
    public $niches = null;
    public function mount($building_id)
    {
        $this->niches = \App\Models\Niche::where('building_id',$building_id)->get();
    }
    public function render()
    {
        return view('livewire.admin.forecast.niche');
    }
}
