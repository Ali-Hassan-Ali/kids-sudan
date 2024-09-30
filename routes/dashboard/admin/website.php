<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Admin\Websites\BannerController;

//banner banner
Route::controller(BannerController::class)
    ->prefix('banner')->name('banner.')->group(function () {

    Route::get('/', 'index')->name('index');
    Route::post('store', 'store')->name('store');

});