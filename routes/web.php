<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('login', function(){
    return view('login');
})->name('login');

Route::post('login', LoginController::class)->name('login.attempt');

Route::view('dashboard', 'dashboard')->name('dashboard');
Route::post('logout', function(){
    Auth::guard('web')->logout();
    Session::invalidate();
    Session::regenerateToken();

    return redirect('/login');
})->name('logout');

Route::view('register','register')
    ->middleware('auth')
    ->name('register');
Route::post('register', RegisterController::class)->name('register.store');