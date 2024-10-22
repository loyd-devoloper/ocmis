<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class MemorialView extends Component
{
    public $memorial = [];
    public function mount($memorial_id)
    {
        $this->memorial =  $memorial = \App\Models\Memorial::where('id',$memorial_id)->first();
    }
    public function render()
    {

        return view('livewire.customer.memorial-view');
    }
}
