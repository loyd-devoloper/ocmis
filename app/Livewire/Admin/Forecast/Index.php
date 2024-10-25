<?php

namespace App\Livewire\Admin\Forecast;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $buildings = \App\Models\Building::get();
        return view('livewire.admin.forecast.index',compact('buildings'));
    }
}
