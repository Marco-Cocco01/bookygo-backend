<?php

use Illuminate\Support\Facades\Route;
use Modules\Permissions\app\Http\Controllers\PermissionsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/permissions', function () {
        return view('permissions::index');
    })->name('permissions.index');
});
