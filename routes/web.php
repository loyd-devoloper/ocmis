<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',\App\Livewire\Customer\Home::class)->name('home');
Route::get('/niches',\App\Livewire\Customer\Niches::class)->name('niches');
Route::get('/niches/building/{id}',\App\Livewire\Customer\NichesBuilding::class)->name('niches.building');
Route::get('/niches/payment/{niche_id}',\App\Livewire\Customer\NichePayment::class)->name('niches.payment');
Route::get('/services',\App\Livewire\Customer\Services::class)->name('services');
Route::get('/login',\App\Livewire\Auth\Login::class)->name('login');
Route::get('/register',\App\Livewire\Auth\Register::class)->name('register');

Route::get('/logout',function(Request $request){
    // $request->session()->invalidate();

    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::middleware('admin.only')->prefix('admin')->group(function () {
    Route::get('users',\App\Livewire\Admin\Users::class)->name('admin.users');
    Route::get('niches/Building',\App\Livewire\Admin\Niches\Building::class)->name('admin.niches.building');
    Route::get('niches/niche',\App\Livewire\Admin\Niches\Niche::class)->name('admin.niches.niche');
    Route::get('niches/urn',\App\Livewire\Admin\Niches\Urn::class)->name('admin.niches.urn');

    Route::get('Services/Category',\App\Livewire\Admin\Services\Category::class)->name('admin.services.category');


    Route::get('Shop/Category',\App\Livewire\Admin\Shop\Category::class)->name('admin.shop.category');
    Route::get('Shop/Seller',\App\Livewire\Admin\Shop\Seller::class)->name('admin.shop.seller');
    Route::get('Shop/Product',\App\Livewire\Admin\Shop\Product::class)->name('admin.shop.product');
});
