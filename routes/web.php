<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {

return to_route('dashboard.admin.index');

// test

//     ///////////////////////// single  //////////////////////////////////

//     $items = [
//         'name'  => 'name value',
//         'email' => 'email value',
//     ];

//     setting('item_single')->save($items);

//     // dd(setting('item_single'), setting('item_single')->name, setting('item_single')->value);//name value

//     ///////////////////////// singleLanguage  //////////////////////////////////

//     $items = [
//         'name'  => ['ar' => 'name ar', 'en' => 'name en'],
//         'email' => ['ar' => 'email ar', 'en' => 'email en'],
//     ];

//     setting('single_language')->save($items);

//     // dd(setting('single_language')->name);//default lang 

//     ////////////////////////////  singleMultiple  ///////////////////////////////

//    $items = [
//         [
//             'name'  => 'name value 1',
//             'email' => 'email value 1',
//         ],
//         [
//             'name'  => 'name value 2',
//             'email' => 'email value 2',
//         ],
//         [
//             'name'  => 'name value 3',
//             'email' => 'email value 3',
//         ]
//     ];

//     setting('single_multiple')->save($items);
//     // dd(setting('item')->get());
//     foreach (setting('single_multiple')->get() as $item) {
//         // dd($item->name, $item->email); //name value 1
//     }

//     ////////////////////////////  singleMultipleLangugage  ///////////////////////////////

//     $items = [
//         [
//             'name'  => ['ar' => 'name value 1 ar', 'en' => 'name value 1 en'],
//             'email' => ['ar' => 'email value 1 ar', 'en' => 'email value 1 en'],
//         ],
//         [
//             'name'  => ['ar' => 'name value 2 ar', 'en' => 'name value 2 en'],
//             'email' => ['ar' => 'email value 2 ar', 'en' => 'email value 2 en'],
//         ],
//         [
//             'name'  => ['ar' => 'name value 3 ar', 'en' => 'name value 3 en'],
//             'email' => ['ar' => 'email value 3 ar', 'en' => 'email value 3 en'],
//         ]
//     ];

//     setting('single_multiple_langugage')->save($items);

//     foreach (setting('single_multiple_langugage')->get() as $item) {
// // /        dd($item->name, $item->email); // defult lang
//         // dd($item->name->en) // name value 1 ar
//     }

//     ////////////////////////////  Multiple  ///////////////////////////////

//     $items = [
//         [
//             'name' => 'name 1 multiples',
//             'email' => 'email 1 multiples',
//         ],
//         [
//             'name' => 'name 2 multiples',
//             'email' => 'email 2 multiples',
//         ],
//         [
//             'name' => 'name 3 multiples',
//             'email' => 'email 3 multiples',
//         ],
//     ];

//     setting('multiple')->save($items);

//     foreach (setting('multiple')->get() as $key => $item) {
        
//         // dd($item->name); //name 1
//     }

//     ////////////////////////////  MultipleLangugage  ///////////////////////////////

//     $items = [
//         [
//             'name' => ['ar' => 'name value 1 ar', 'en' => 'name value 1 en'],
//             'email' => ['ar' => 'email value 1 ar', 'en' => 'email value 1 en'],
//         ],
//         [
//             'name' => ['ar' => 'name value 2 ar', 'en' => 'name value 2 en'],
//             'email' => ['ar' => 'email value 2 ar', 'en' => 'email value 2 en'],
//         ],
//         [
//             'name' => ['ar' => 'name value 3 ar', 'en' => 'name value 3 en'],
//             'email' => ['ar' => 'email value 3 ar', 'en' => 'email value 3 en'],
//         ],
//     ];

//     setting('multiple_langugage')->save($items);

//     foreach (setting('multiple_langugage')->get() as $item) {

//         dd($item->name,$item->email);
//     }


    return view('welcome');
});
