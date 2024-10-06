<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class Services extends Component
{
    public function render()
    {
        $services = \App\Models\Category::get();
        return view('livewire.customer.services', compact('services'));
    }
}
