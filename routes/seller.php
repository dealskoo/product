<?php

use Dealskoo\Product\Http\Controllers\Seller\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'seller_locale'])->prefix(config('seller.route.prefix'))->name('seller.')->group(function () {

    Route::middleware(['guest:seller'])->group(function () {

    });

    Route::middleware(['auth:seller', 'verified:seller.verification.notice', 'seller_active'])->group(function () {

        Route::resource('products', ProductController::class)->except('show');
        
        Route::middleware(['password.confirm:seller.password.confirm'])->group(function () {

        });
    });
});
