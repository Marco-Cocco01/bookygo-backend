<?php

use Illuminate\Support\Facades\Route;
use Modules\Company\app\Http\Controllers\CompanyController;
use Modules\Company\app\Livewire\AddCompany;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/company', function () {
        return view('company::index');
    })->name('company.index');

    Route::get('/add-company', AddCompany::class)->name('company.add');
    Route::get('/edit-company/{id}', AddCompany::class)->name('company.edit');
});