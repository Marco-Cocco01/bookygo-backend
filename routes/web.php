<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    //return view('welcome');
    return redirect('login');
})->name('home');

Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/addbupsw/{token}', [AuthController::class, 'addbupsw'])->name('addbupsw');
Route::post('/addbupsw/{token}', [AuthController::class, 'storeBupsw'])->name('addbupsw.store');

Route::get('/register/email-verify', function () {
    return view('auth.registration-verify-notice');
})->name('registration.verify-notice');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';