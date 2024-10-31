<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Filament\Notifications\Notification;

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

Route::get('/', \App\Livewire\Customer\Home::class)->name('home');
Route::get('/niches', \App\Livewire\Customer\Niches::class)->name('niches');
Route::get('/niches/building/{id}', \App\Livewire\Customer\NichesBuilding::class)->name('niches.building');
Route::get('/niches/view/{id}', \App\Livewire\Customer\Niche\View::class)->name('niches.view');
Route::get('/niches/payment/{niche_id}', \App\Livewire\Customer\NichePayment::class)->name('niches.payment');
Route::get('/niches/payment/checkout/{niche_id}', \App\Livewire\Customer\Niche\Checkout::class)->name('niches.payment.checkout');


Route::get('/services', \App\Livewire\Customer\Services::class)->name('services');
Route::get('/services/payment/{service_id}', \App\Livewire\Customer\Services\PaymentPage::class)->name('services.payment');
Route::get('/services/payment/success/{service_id}', function ($service_id) {
    \App\Models\UserService::where('id', $service_id)->update([
        'status' => \App\Enums\StatusEnum::Paid
    ]);

    return redirect()->route('my_transaction');
})->name('services.payment.success');
Route::get('/about', \App\Livewire\Customer\About::class)->name('about');

Route::get('/shop', \App\Livewire\Customer\Shop::class)->name('shop');

Route::get('/Memorial', \App\Livewire\Customer\Memorial::class)->name('memorial');
Route::get('/MemorialView/{memorial_id}', \App\Livewire\Customer\MemorialView::class)->name('memorial_view');


Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
Route::get('verified/{id}', function ($id) {
    $user = User::where('id', $id)->first();
    $user->markEmailAsVerified();
    Auth::login($user);
    Notification::make()
        ->title('Verify successfully')
        ->success()
        ->persistent()
        ->send();
    return redirect()->route('home');
});
Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');

Route::middleware(['customer.only'])->group(function () {
    Route::get('/cart', \App\Livewire\Customer\Cart::class)->name('cart');

    Route::get('setting', \App\Livewire\Customer\Setting::class)->name('customer.setting');

    Route::get('/MyTransaction', \App\Livewire\Customer\MyTransaction::class)->name('my_transaction');
    Route::get('/MyProduct', \App\Livewire\Customer\MyProduct::class)->name('my_product');
    Route::get('/MyMemorial', \App\Livewire\Customer\MyMemorial::class)->name('my_memorial');
    Route::get('/MyNiche', \App\Livewire\Customer\MyNiche::class)->name('my_niche');
});


Route::get('/logout', function (Request $request) {
    // $request->session()->invalidate();

    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::middleware('admin.only')->prefix('admin')->group(function () {

    Route::get('setting', \App\Livewire\Admin\Setting::class)->name('admin.setting');

    Route::get('users', \App\Livewire\Admin\Users::class)->name('admin.users');
    Route::get('niches/Building', \App\Livewire\Admin\Niches\Building::class)->name('admin.niches.building');
    Route::get('niches/niche', \App\Livewire\Admin\Niches\Niche::class)->name('admin.niches.niche');
    Route::get('niches/urn', \App\Livewire\Admin\Niches\Urn::class)->name('admin.niches.urn');
    Route::get('niches/sales', \App\Livewire\Admin\Niches\Sales::class)->name('admin.niches.sales');

    Route::get('Services/Category', \App\Livewire\Admin\Services\Category::class)->name('admin.services.category');
    Route::get('Services/Priest', \App\Livewire\Admin\Services\Priest::class)->name('admin.services.priest');
    Route::get('Services/Transaction', \App\Livewire\Admin\Services\Transaction::class)->name('admin.services.transaction');
    Route::get('Services/Sales', \App\Livewire\Admin\Services\Sales::class)->name('admin.services.sales');
    Route::get('Services/Memorial', \App\Livewire\Admin\Services\Memorial::class)->name('admin.services.memorial');


    Route::get('Shop/Transaction', \App\Livewire\Admin\Shop\Transaction::class)->name('admin.shop.transaction');
    Route::get('Shop/Category', \App\Livewire\Admin\Shop\Category::class)->name('admin.shop.category');
    Route::get('Shop/Seller', \App\Livewire\Admin\Shop\Seller::class)->name('admin.shop.seller');
    Route::get('Shop/Product', \App\Livewire\Admin\Shop\Product::class)->name('admin.shop.product');
    Route::get('Shop/Sales', \App\Livewire\Admin\ShopSales::class)->name('admin.shop.sales');

    Route::get('Forecast/Buildings', \App\Livewire\Admin\Forecast\Index::class)->name('admin.forecast.buildings');
    Route::get('Forecast/Sales', \App\Livewire\Admin\Forecast\sales::class)->name('admin.forecast.sales');
    Route::get('Forecast/Niches/{building_id}', \App\Livewire\Admin\Forecast\Niche::class)->name('admin.forecast.niches');
    Route::get('Forecast/Niche/{niche_id}', \App\Livewire\Admin\Forecast\View::class)->name('admin.forecast.view');

    Route::get('Forecast/Sales/Service/{records}', \App\Livewire\Admin\ServicePrintTable::class)->name('admin.forecast.service_print');


    Route::get('Forecast/Sales/Service', function () {
        return view('livewire.admin.printService');
    })->name('admin.forecast.print');
    Route::get('Forecast/Sales/Shop', function () {
        return view('livewire.admin.printShop');
    })->name('admin.forecast.printshop');
    Route::get('Forecast/Sales/Niche', function () {
        return view('livewire.admin.printNiche');
    })->name('admin.forecast.printNiche');
});
