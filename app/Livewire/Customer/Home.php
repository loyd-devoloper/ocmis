<?php

namespace App\Livewire\Customer;

use Livewire\Attributes\Title;
use Livewire\Component;

class Home extends Component
{
    #[Title("Home")]
    public function render()
    {
        return view('livewire.customer.home');
    }
}
