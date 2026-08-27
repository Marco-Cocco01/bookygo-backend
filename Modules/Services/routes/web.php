<?php

use Illuminate\Support\Facades\Route;
use Modules\Services\Http\Controllers\ServicesController;
use Modules\Services\app\Livewire\AddService;
use Modules\Services\app\Livewire\ServicesList;

Route::middleware(['auth', 'verified'])->group(function () {
   Route::get('/services', function () {
        return view('services::index');
    })->name('services.index');

    Route::get('/add-service', AddService::class)->name('service.add');
    Route::get('/edit-service/{id}', AddService::class)->name('service.edit');
});
