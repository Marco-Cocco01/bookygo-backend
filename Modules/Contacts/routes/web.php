<?php

use Illuminate\Support\Facades\Route;
use Modules\Contacts\Http\Controllers\ContactsController;
use Modules\Contacts\app\Livewire\AddContact;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/contacts', function () {
        return view('contacts::index');
    })->name('contacts.index');
    //Route::resource('contacts', ContactsController::class)->names('contacts.index');
    Route::get('/add-contact', AddContact::class)->name('contact.add');
    Route::get('/edit-contact/{id}', AddContact::class)->name('contact.edit');
});
