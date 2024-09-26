<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return $datas = getItemTagesSetting('websit_keywords', 'ar');
    dd($datas);
    // dd(getItemTagesSetting('websit_keywords', 'ar')->toArray());

    foreach ($datas as $key => $value) {
        dd($value, $key);
    }
    return view('welcome');
});
