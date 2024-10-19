<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\AwarenessEntryController;

//public routes
Route::get('/', [CustomAuthController::class, 'dashboard']);
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('logout', [CustomAuthController::class, 'signOut'])->name('signout');

//protected routes
Route::middleware(['auth'])->group(function () {
    Route::resource('awarenessEntry', AwarenessEntryController::class);
    Route::put('/awarenessEntry/{id}', [AwarenessEntryController::class, 'update'])->name('awarenessEntry.update');
});
