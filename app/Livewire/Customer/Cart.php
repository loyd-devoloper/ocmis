<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Luigel\Paymongo\Facades\Paymongo;
use Filament\Notifications\Notification;

class Cart extends Component
{
    public $total = 0;
    public $payment_method = 'Cash';
    public $products = [];

    public $invoice = false;
    public $ref = '';

    public function changeQuantity($type,\App\Models\MyCart $id)
    {

        $id->update([
            'quantity' =>  $type == 'increment' ? (int)$id->quantity + 1 : (int)$id->quantity - 1
        ]);
        return $this->redirectRoute('cart');
    }
    public function removeProduct(\App\Models\MyCart $id)
    {

        $id->delete();
        Notification::make()
        ->title('Deleted successfully')
        ->success()
        ->send();
        return $this->redirectRoute('cart');
    }

    public function checkout()
    {

       $orders = \App\Models\ShopOrder::create([
            'user_id'=>Auth::id(),
            'status'=> \App\Enums\StatusEnum::NotPaid->value,
            'payment_method'=>$this->payment_method,
            'items'=>json_encode($this->products),
            'total'=>$this->total
       ]);
       if($this->payment_method == 'Gcash')
       {
        $checkout = Paymongo::checkout()->create([
            'cancel_url' => route( 'cart'),
            'billing' => [
                'name' => Auth::user()->fname." ".Auth::user()->mname." ".Auth::user()->lname,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->contact,
            ],
            'description' =>"Invoice No.: $orders->id",
            'line_items' => $this->products,
            'payment_method_types' => [
                'gcash'

            ],
            'success_url' =>route('my_product'),
            'statement_descriptor' => 'OCMIS ONLINE PAYMENT',
            'metadata' => [
                'Key' => 'Value'
            ]
        ]);

        $orders->update([
            'payment_ref' => $checkout->getData()['id'],
            'checkout_url'=>$checkout->getData()['checkout_url']
        ]);
        \App\Models\MyCart::with('product')->where('user_id',Auth::id())->delete();
        return $this->redirect($checkout->getData()['checkout_url']);
       }
       $this->ref = $orders->id;
       $this->invoice = true;

       \App\Models\MyCart::with('product')->where('user_id',Auth::id())->delete();


    }
    public function render()
    {
        $carts = \App\Models\MyCart::with('product')->where('user_id',Auth::id())->get();
        $this->products = [];
        $this->total = 0;
        foreach($carts as $cart)
        {
            $this->total +=  (float)$cart->product?->price * (float)$cart->quantity;
            $this->products[] =   [
                'amount' => (float)$cart->product?->price * 100,
                'currency' => 'PHP',

                'name' => $cart->product?->product_name,
                'quantity' => (int)$cart->quantity
            ];
        }

        return view('livewire.customer.cart',compact('carts'));
    }
}
