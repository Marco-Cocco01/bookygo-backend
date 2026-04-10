<?php

use Illuminate\Support\Facades\Route;
use Modules\Contacts\Http\Controllers\ContactsController;
use Modules\Company\app\Livewire\AddContact;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/contacts', function () {
        return view('contacts::index');
    })->name('contacts.index');
    //Route::resource('contacts', ContactsController::class)->names('contacts.index');
});
