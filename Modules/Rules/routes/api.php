<?php

use Illuminate\Support\Facades\Route;
use Modules\Rules\Http\Controllers\RulesController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('rules', RulesController::class)->names('rules');
});
