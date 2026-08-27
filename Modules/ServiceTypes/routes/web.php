<?php

use Illuminate\Support\Facades\Route;
use Modules\ServiceTypes\Http\Controllers\ServiceTypesController;
use Modules\ServiceTypes\app\Livewire\AddServiceType;
use Modules\ServiceTypes\app\Livewire\ServiceTypeList;

Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/service-types', function () {
        return view('servicetypes::index');
    })->name('service-types.index');

    Route::get('/add-service-type', AddServiceType::class)->name('service-type.add');
    Route::get('/edit-service-type/{id}', AddServiceType::class)->name('service-type.edit');
});
