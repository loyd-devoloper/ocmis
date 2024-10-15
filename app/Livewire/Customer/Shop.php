<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class Shop extends Component
{

    public function addToCart($id)
    {

        $product =  \App\Models\MyCart::where('user_id',Auth::id())->where('product_id',$id)->first();
        if($product)
        {
            $product->update([
                'quantity' => (int)$product->quantity + 1
            ]);
        }else{
           \App\Models\MyCart::create([
                'user_id'=>Auth::id(),
                'product_id'=>$id,
                'quantity'=>1
            ]);
        }
        Notification::make()
        ->title('Item Added to Cart')
        ->color(Color::Green)
        ->success()
        ->send();
    }
    public function render()
    {
        $products = \App\Models\ShopProduct::with('categoryInfo')->get();
        return view('livewire.customer.shop',compact('products'));
    }
}
