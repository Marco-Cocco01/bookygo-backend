<?php

use Illuminate\Support\Facades\Route;
use Modules\ServiceTypes\Http\Controllers\ServiceTypesController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('servicetypes', ServiceTypesController::class)->names('servicetypes');
});
