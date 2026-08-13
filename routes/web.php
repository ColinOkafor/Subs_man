<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('login', function(){
    return view('login');
})->name('login');

Route::post('login', LoginController::class)
        ->middleware('throttle:7,1')
        ->name('login.attempt');

Route::view('dashboard', 'dashboard')->name('dashboard');
Route::post('logout', function(){
    Auth::guard('web')->logout();
    Session::invalidate();
    Session::regenerateToken();

    return redirect('/login');
})->name('logout');

Route::view('register','register')
    ->middleware('guest')
    ->name('register');
Route::post('register', RegisterController::class)->name('register.store');

// --- ADMIN ROUTES (F7 Requirements) ---
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // F7.1 Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // F7.2 User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/deactivate', [AdminController::class, 'deactivateUser'])->name('users.deactivate');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');
    
    // F7.3 Queue Monitor
    Route::get('/queue', [AdminController::class, 'queue'])->name('queue');
    
});
Route::middleware(['auth'])->group(function(){
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/create_sub', [SubscriptionController::class, 'create'])->name('subscription.create');
    Route::post('/subscriptions', [Subscriptions::class, 'store'])->name('subscriptions.store');
    Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show'])->name(subscriptions.show);
});