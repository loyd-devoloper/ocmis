<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/login',\App\Livewire\Auth\Login::class)->name('login');
Route::get('/register',\App\Livewire\Auth\Register::class)->name('register');

Route::prefix('admin')->group(function () {
    Route::get('users',\App\Livewire\Admin\Users::class)->name('admin.users');
});
