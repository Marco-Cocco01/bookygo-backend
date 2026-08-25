<?php

use Illuminate\Support\Facades\Route;
use Modules\ServiceTypes\Http\Controllers\ServiceTypesController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('servicetypes', ServiceTypesController::class)->names('servicetypes');
});
