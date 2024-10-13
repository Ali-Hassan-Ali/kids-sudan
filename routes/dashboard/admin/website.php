<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Admin\Websites\BannerController;
use App\Http\Controllers\Dashboard\Admin\Websites\FaqController;
use App\Http\Controllers\Dashboard\Admin\Websites\SkillsController;
use App\Http\Controllers\Dashboard\Admin\Websites\ToolsController;
use App\Http\Controllers\Dashboard\Admin\Websites\CreativesController;
use App\Http\Controllers\Dashboard\Admin\Websites\ClientController;
use App\Http\Controllers\Dashboard\Admin\Websites\VolunteeringController;
use App\Http\Controllers\Dashboard\Admin\Websites\ServicesController;

//website banner
Route::controller(BannerController::class)
    ->prefix('banner')->name('banner.')->group(function () {

    Route::get('/', 'index')->name('index');
    Route::post('store', 'store')->name('store');

});


//website faqs
Route::controller(FaqController::class)
    ->prefix('faqs')->name('faqs.')
    ->group(function () {

        Route::get('data', 'data')->name('data');
        Route::post('status', 'status')->name('status');
        Route::delete('bulk_delete', 'bulkDelete')->name('bulk_delete');

        Route::prefix('sortable')->name('sortable.')->group(function () {

            Route::get('/', 'sortablePage')->name('index');
            Route::post('/store', 'storeSortable')->name('store');

        });
    });
Route::resource('faqs', FaqController::class)->except('show');


//website skills
Route::controller(SkillsController::class)
    ->prefix('skills')->name('skills.')
    ->group(function () {

        Route::get('data', 'data')->name('data');
        Route::post('status', 'status')->name('status');
        Route::delete('bulk_delete', 'bulkDelete')->name('bulk_delete');

        Route::prefix('sortable')->name('sortable.')->group(function () {

            Route::get('/', 'sortablePage')->name('index');
            Route::post('/store', 'storeSortable')->name('store');

        });
    });
Route::resource('skills', SkillsController::class)->except('show');


//website tools
Route::controller(ToolsController::class)
    ->prefix('tools')->name('tools.')
    ->group(function () {

        Route::get('data', 'data')->name('data');
        Route::post('status', 'status')->name('status');
        Route::delete('bulk_delete', 'bulkDelete')->name('bulk_delete');

        Route::prefix('sortable')->name('sortable.')->group(function () {

            Route::get('/', 'sortablePage')->name('index');
            Route::post('/store', 'storeSortable')->name('store');

        });
    });
Route::resource('tools', ToolsController::class)->except('show');


//website creatives
Route::controller(CreativesController::class)
    ->prefix('creatives')->name('creatives.')
    ->group(function () {

        Route::get('data', 'data')->name('data');
        Route::post('status', 'status')->name('status');
        Route::delete('bulk_delete', 'bulkDelete')->name('bulk_delete');

        Route::prefix('sortable')->name('sortable.')->group(function () {

            Route::get('/', 'sortablePage')->name('index');
            Route::post('/store', 'storeSortable')->name('store');

        });

    });
Route::resource('creatives', CreativesController::class)->except('show');

//website clients
Route::controller(ClientController::class)
    ->prefix('clients')->name('clients.')
    ->group(function () {

        Route::get('data', 'data')->name('data');
        Route::post('status', 'status')->name('status');
        Route::delete('bulk_delete', 'bulkDelete')->name('bulk_delete');

        Route::prefix('sortable')->name('sortable.')->group(function () {

            Route::get('/', 'sortablePage')->name('index');
            Route::post('/store', 'storeSortable')->name('store');

        });

    });
Route::resource('clients', ClientController::class)->except('show');

//website volunteerings
Route::controller(VolunteeringController::class)
    ->prefix('volunteerings')->name('volunteerings.')
    ->group(function () {

        Route::get('data', 'data')->name('data');
        Route::post('status', 'status')->name('status');
        Route::delete('bulk_delete', 'bulkDelete')->name('bulk_delete');

        Route::prefix('sortable')->name('sortable.')->group(function () {

            Route::get('/', 'sortablePage')->name('index');
            Route::post('/store', 'storeSortable')->name('store');

        });

    });
Route::resource('volunteerings', VolunteeringController::class)->except('show');


//website services
Route::controller(ServicesController::class)
    ->prefix('services')->name('services.')
    ->group(function () {

        Route::get('data', 'data')->name('data');
        Route::post('status', 'status')->name('status');
        Route::delete('bulk_delete', 'bulkDelete')->name('bulk_delete');

        Route::prefix('sortable')->name('sortable.')->group(function () {

            Route::get('/', 'sortablePage')->name('index');
            Route::post('/store', 'storeSortable')->name('store');

        });

    });
Route::resource('services', ServicesController::class)->except('show');