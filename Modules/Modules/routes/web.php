<?php

use Illuminate\Support\Facades\Route;
use Modules\Modules\app\Http\Controllers\ModulesController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/modules', function () {
        return view('modules::index');
    })->name('modules.index');
});
