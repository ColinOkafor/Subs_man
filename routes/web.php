<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ProfileController;

// Welcome page
Route::get('/', function () {
    return view('login');
});

// --- AUTH ---
Route::get('login', function () {
    return view('login');
})->middleware('guest')->name('login');

Route::post('login', LoginController::class)
    ->middleware('throttle:7,1')
    ->name('login.attempt');

Route::post('logout', function () {
    Auth::guard('web')->logout();
    Session::invalidate();
    Session::regenerateToken();
    return redirect('/login');
})->name('logout');

Route::get('register', function () {
    return view('register');
})->middleware('guest')->name('register');

Route::post('register', RegisterController::class)->name('register.store');

// --- SUBSCRIPTIONS & PROFILE (authenticated users) ---
Route::middleware(['auth'])->group(function () {

    // Subscriptions
    Route::get('/subscriptions',                       [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/create',                [SubscriptionController::class, 'create'])->name('subscriptions.create');
    Route::post('/subscriptions',                      [SubscriptionController::class, 'store'])->name('subscriptions.store');
    Route::get('/subscriptions/{subscription}',        [SubscriptionController::class, 'show'])->name('subscriptions.show');
    Route::get('/subscriptions/{subscription}/edit',   [SubscriptionController::class, 'edit'])->name('subscriptions.edit');
    Route::put('/subscriptions/{subscription}',        [SubscriptionController::class, 'update'])->name('subscriptions.update');
    Route::delete('/subscriptions/{subscription}',     [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');

    // Profile
    Route::get('/profile',          [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::delete('/profile',       [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// --- ADMIN ---
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',                 [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users',                     [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/deactivate', [AdminController::class, 'deactivateUser'])->name('users.deactivate');
    Route::delete('/users/{user}',           [AdminController::class, 'deleteUser'])->name('users.destroy');
    Route::get('/queue',                     [AdminController::class, 'queue'])->name('queue');
});