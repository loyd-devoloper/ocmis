<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class NichesBuilding extends Component
{
    public $building = [];
    public $buildingName = '';
    public function mount($id)
    {
        $building = \App\Models\Building::with('niches')->where("id", $id)->first();
        $this->building = $building;
        $this->buildingName = $building?->name;
    }
    public function render()
    {
        return view('livewire.customer.niches-building');
    }
}
