<?php

use Illuminate\Support\Facades\Route;
use Modules\Categories\Http\Controllers\CategoriesController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/categories', function () {
        return view('categories::index');
    })->name('categories.index');

    Route::get('/add-categories', function () {
        return view('categories::add');
    })->name('categories.add');

    Route::get('/sub-categories/{id_parent}', function ($id_parent) {
        
        return view('categories::subcategories', ['id_parent' => $id_parent]);
    })->name('sub-categories.index');
});

