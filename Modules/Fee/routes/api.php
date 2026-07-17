<?php

use Illuminate\Support\Facades\Route;
use Modules\Fee\Http\Controllers\FeeController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('fees', FeeController::class)->names('fee');
});
