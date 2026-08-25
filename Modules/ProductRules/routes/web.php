<?php

use Illuminate\Support\Facades\Route;
use Modules\ProductRules\Http\Controllers\ProductRulesController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('productrules', ProductRulesController::class)->names('productrules');
});
