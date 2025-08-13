<?php

use App\Http\Controllers\CarLoanDetailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function(){
    /** DASHBOARD */
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /** CAR LOAN DETAIL */
    Route::get('/car-loan-register', [CarLoanDetailController::class, 'index'])->name('car-loan-register');
    Route::post('/car-loan-register', [CarLoanDetailController::class, 'create'])->name('car-loan-register');
    Route::get('/car-loan-details', [CarLoanDetailController::class, 'show'])->name('car-loan-details');
    Route::put('/car-loan-details', [CarLoanDetailController::class, 'update'])->name('car-loan-details');

    /** PAYMENTS */
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
    Route::post('/payments-create', [PaymentController::class, 'create'])->name('payments-create');
    Route::post('/payments-update/{paymentId}', [PaymentController::class, 'update'])->name('payments-update');
    Route::delete('/payments-delete/{paymentId}', [PaymentController::class, 'destroy'])->name('payments-delete');
    Route::post('/payments-delete/{paymentId}', [PaymentController::class, 'destroy']); // for spoofed method

    /** SETTINGS 
     * The routes should not be the same name, example: for profile add settings/profile and for password add settings/password as using only 'settings' will overwrite the first one
    */
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings-update-profile');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings-update-password');
    Route::post('/settings/other', [SettingsController::class, 'updateOtherSettings'])->name('settings-update-other');

    /** LOGOUT */
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
});



Route::middleware('guest')->group(function(){
    /** LOGIN */
    Route::get('/login', function () {
        return Inertia::render('Login');
    })->name('login');

    Route::post('login', [UserController::class, 'login'])->name('login');

    /** REGISTER */
    Route::get('/register', function () {
        return Inertia::render('Register');
    })->name('register');

    Route::post('register', [UserController::class, 'register'])->name('register');
});

Route::get('/offline', function () {
    return view('vendor/laravelpwa/offline');
});



