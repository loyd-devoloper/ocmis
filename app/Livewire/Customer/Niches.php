<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class Niches extends Component
{
    public function render()
    {
        $buildings = \App\Models\Building::orderBy("created_at","desc")->get();
        return view('livewire.customer.niches',compact('buildings'));
    }
}
