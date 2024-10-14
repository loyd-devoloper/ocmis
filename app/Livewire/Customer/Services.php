<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\Attributes\Title;

class Services extends Component
{
    #[Title('Services')]
    public function render()
    {
        $services = \App\Models\Category::get();
        return view('livewire.customer.services', compact('services'));
    }
}
