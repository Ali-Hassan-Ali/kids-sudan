<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Admin\Websites\BannerController;
use App\Http\Controllers\Dashboard\Admin\Websites\SkillsController;
use App\Http\Controllers\Dashboard\Admin\Websites\ToolsController;

//website banner
Route::controller(BannerController::class)
    ->prefix('banner')->name('banner.')->group(function () {

    Route::get('/', 'index')->name('index');
    Route::post('store', 'store')->name('store');

});

//website skills
Route::controller(SkillsController::class)
    ->prefix('skills')->name('skills.')->group(function () {

    Route::get('/', 'index')->name('index');
    Route::post('store', 'store')->name('store');

});

//website tools
Route::controller(ToolsController::class)
    ->prefix('tools')->name('tools.')->group(function () {

    Route::get('/', 'index')->name('index');
    Route::post('store', 'store')->name('store');

});