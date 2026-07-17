<?php

use Illuminate\Support\Facades\Route;
use Modules\Fee\Http\Controllers\FeeController;
use Modules\Fee\app\Livewire\AddFee;

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/fees', function () {
        return view('fee::index');
    })->name('fee.index');

    Route::get('/add-fee', AddFee::class)->name('fee.add');
    Route::get('/edit-fee/{id}', AddFee::class)->name('fee.edit');
});
