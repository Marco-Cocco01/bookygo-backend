<?php

use Illuminate\Support\Facades\Route;
use Modules\ProductRules\Http\Controllers\ProductRulesController;
use Modules\ProductRules\app\Livewire\AddProductRules;
use Modules\ProductRules\app\Livewire\ProductRulesList;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/product-rules', function () {
        return view('productrules::index');
    })->name('product-rules.index');

    Route::get('/add-product-rule', AddProductRules::class)->name('product-rule.add');
    Route::get('/edit-product-rule/{id}', AddProductRules::class)->name('product-rule.edit');
});
