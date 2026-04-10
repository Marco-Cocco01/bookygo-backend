<?php

use Illuminate\Support\Facades\Route;
use Modules\Rules\app\Http\Controllers\RulesController;

Route::middleware(['auth', 'verified'])->group(function () {
    //Route::resource('clients', ClientsController::class)->names('clients');
    Route::get('/rules', function () {
        return view('rules::index');
    })->name('rules.index');
});
