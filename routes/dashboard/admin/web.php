<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Admin\IndexController;

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('language/{language:code}', [IndexController::class, 'changeLanguage'])->name('changeLanguage');