<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Admin\Websit\BannerController;

//banner
Route::controller(BannerController::class)
    ->prefix('admins')->name('admins.')
    ->group(function () {

        Route::get('data', 'data')->name('data');
        Route::post('status', 'status')->name('status');
        Route::delete('bulk_delete', 'bulkDelete')->name('bulk_delete');

    });
Route::resource('admins', BannerController::class);