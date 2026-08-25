<?php

use Illuminate\Support\Facades\Route;
use Modules\ProductRules\Http\Controllers\ProductRulesController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('productrules', ProductRulesController::class)->names('productrules');
});
