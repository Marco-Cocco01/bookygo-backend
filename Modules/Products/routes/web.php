<?php

use Illuminate\Support\Facades\Route;
use Modules\Products\Http\Controllers\ProductsController;
use Modules\Products\app\Livewire\AddProduct;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/products', function () {
        return view('product::index');
    })->name('products.index');

    Route::get('/add-product', AddProduct::class)->name('product.add');
    Route::get('/edit-product/{id}', AddProduct::class)->name('product.edit');
});
