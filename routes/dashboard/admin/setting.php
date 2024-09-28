<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dashboard\Admin\Settings\WebsitController;
use App\Http\Controllers\Dashboard\Admin\Settings\MetaController;
use App\Http\Controllers\Dashboard\Admin\Settings\ContactController;
use App\Http\Controllers\Dashboard\Admin\Settings\MediaController;
use App\Http\Controllers\Dashboard\Admin\Settings\FaqController;

//settings meta
Route::controller(MetaController::class)
    ->prefix('meta')->name('meta.')->group(function () {

    Route::get('/', 'index')->name('index');
    Route::post('store', 'store')->name('store');

});

//settings websit
Route::controller(WebsitController::class)
    ->prefix('websit')->name('websit.')->group(function () {

    Route::get('/', 'index')->name('index');
    Route::post('store', 'store')->name('store');

});

//settings contact
Route::controller(ContactController::class)
    ->prefix('contact')->name('contact.')->group(function () {

    Route::get('/', 'index')->name('index');
    Route::post('store', 'store')->name('store');

});

//settings media
Route::controller(MediaController::class)
    ->prefix('media')->name('media.')->group(function () {

    Route::get('/', 'index')->name('index');
    Route::post('store', 'store')->name('store');

});

//settings faq
Route::controller(FaqController::class)
    ->prefix('faq')->name('faq.')->group(function () {

    Route::get('/', 'index')->name('index');
    Route::post('store', 'store')->name('store');

});