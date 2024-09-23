<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dashboard\Admin\Settings\WebsitController;
use App\Http\Controllers\Dashboard\Admin\Settings\MetaController;
use App\Http\Controllers\Dashboard\Admin\Settings\ContactController;
use App\Http\Controllers\Dashboard\Admin\Settings\MediaController;
use App\Http\Controllers\Dashboard\Admin\Settings\FaqController;

//settings meta
Route::controller(MetaController::class)->group(function () {

    Route::get('meta', 'index')->name('meta.index');
    Route::post('meta/store', 'store')->name('meta.store');

});

//settings websit
Route::controller(WebsitController::class)->group(function () {

    Route::get('websit', 'index')->name('websit.index');
    Route::post('websit/store', 'store')->name('websit.store');

});

//settings contact
Route::controller(ContactController::class)->group(function () {

    Route::get('contact', 'index')->name('contact.index');
    Route::post('contact/store', 'store')->name('contact.store');

});

//settings media
Route::controller(MediaController::class)->group(function () {

    Route::get('media', 'index')->name('media.index');
    Route::post('media/store', 'store')->name('media.store');

});

//settings footer
Route::controller(FaqController::class)->group(function () {

    // //about_page
    // Route::get('about_page', 'aboutPage')->name('about_page.index');
    // Route::post('about_page/store', 'aboutPageStore')->name('about_page.store');

    //faq
    Route::get('faq', 'index')->name('faq.index');
    Route::post('faq/store', 'store')->name('faq.store');

});