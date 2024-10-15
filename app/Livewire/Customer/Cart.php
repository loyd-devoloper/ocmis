<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Cart extends Component
{

    public function changeQuantity($type,\App\Models\MyCart $id)
    {

        $id->update([
            'quantity' =>  $type == 'increment' ? (int)$id->quantity + 1 : (int)$id->quantity - 1
        ]);
    }
    public function render()
    {
        $carts = \App\Models\MyCart::with('product')->where('user_id',Auth::id())->get();
        return view('livewire.customer.cart',compact('carts'));
    }
}
