<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class Shop extends Component
{

    public $show = 0;
    public function addToCart($id)
    {

        $product =  \App\Models\MyCart::where('user_id', Auth::id())->where('product_id', $id)->first();
        $quantity = \App\Models\ShopProduct::where('id', $id)->first();
        if ($quantity) {
            $quantity->update([
                'quantity' => (int)$quantity?->quantity - 1
            ]);
        }
        if ($product) {
            $product->update([
                'quantity' => (int)$product->quantity + 1
            ]);
        } else {
            \App\Models\MyCart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'quantity' => 1
            ]);
        }
        Notification::make()
            ->title('Item Added to Cart')
            ->color(Color::Green)
            ->success()
            ->send();
    }

    public function removeProduct( $id)
    {
        $cart = \App\Models\MyCart::with('product')->where('product_id', $id)->where('user_id', Auth::id())->first();
        $quantity = \App\Models\ShopProduct::where('id', $cart->product_id)->first();
        if ($quantity) {
            $quantity->update([
                'quantity' => (int)$quantity?->quantity + (int)$cart->quantity
            ]);
        }
        $cart->delete();
        Notification::make()
            ->title('Deleted successfully')
            ->success()
            ->send();

    }
    public function changeQuantity($type, $id)
    {
        $cart = \App\Models\MyCart::with('product')->where('product_id', $id)->where('user_id', Auth::id())->first();
        $quantity = \App\Models\ShopProduct::where('id', $cart->product_id)->first();
        if ($quantity) {
            $quantity->update([
                'quantity' => $type == 'increment' ? (int)$quantity?->quantity - 1 : (int)$quantity?->quantity + 1
            ]);
        }
        $cart->update([
            'quantity' =>  $type == 'increment' ? (int)$cart->quantity + 1 : (int)$cart->quantity - 1
        ]);
        // return $this->redirectRoute('cart');
    }
    public function perProduct($id)
    {
        $cart = \App\Models\MyCart::with('product')->where('product_id', $id)->where('user_id', Auth::id())->first();
        if ($cart) {
            return (int)$cart->quantity;
        } else {
            return 0;
        }
    }
    public function render()
    {
        $products = \App\Models\ShopProduct::with('categoryInfo')->where('quantity', '>', 0)->get();
        return view('livewire.customer.shop', compact('products'));
    }
}
