<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/test', function () {

    $items = 'testqaass.png';

    setting('testqaass')->save($items);

    dd(setting('testqaass')->value, $items); // logo.png

    dd(setting('logo'));

    // dd(route('dashboard.admin.index'));

// // return to_route('dashboard.admin.index');

// // test
//     ///////////////////////// single  //////////////////////////////////

$items = [
    'name'  => 'name value new',
    'email' => 'email value',
];

// dd(setting('item_single')->name); // سيعرض "name value new"
// حفظ البيانات
setting('item_single')->save($items);

// استرجاع المصفوفة بالكامل
// dd(setting('item_single')->toArray(), setting('item_single')->name); // سيعرض $items كاملةً

// استرجاع قيمة name فقط



//     ///////////////////////// singleLanguage  //////////////////////////////////

    $items = [
        'name'  => ['ar' => 'name ar', 'en' => 'name en'],
        'email' => ['ar' => 'email ar', 'en' => 'email en'],
    ];

    setting('single_language')->save($items);

    // dd(setting('single_language')->name);//default lang 

//     ////////////////////////////  singleMultiple  ///////////////////////////////

   $items = [
        [
            'name'  => 'name value 1aaaaaaaaaaaaa',
            'email' => 'email value rwa',
        ],
        [
            'name'  => 'name value 2',
            'email' => 'email value 2',
        ],
        [
            'name'  => 'name value 3',
            'email' => 'email value 3',
        ]
    ];

    setting('single_multiple')->save($items);
    // dd(setting('single_multiple')->get());
    // dd(setting('single_multiple'));
    // dd(setting('single_multiple')->get());
    foreach (setting('single_multiple')->get() as $item) {
        // dd($item->email); //name value 1
    }

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
//         // dd($item->name, $item->email); 
//         // dd($item->email); // name value 1 ar
//     }

//     ////////////////////////////  Multiple  ///////////////////////////////

    $items = [
        [
            'name' => 'name 1 multiples',
            'email' => 'email 1 multiples',
        ],
        [
            'name' => 'name 2 multiples',
            'email' => 'email 2 multiples',
        ],
        [
            'name' => 'name 3 multiples',
            'email' => 'email 3 multiples',
        ],
    ];

    setting('multiple')->save($items);

    foreach (setting('multiple')->get() as $key => $item) {
        
        dd($item->name); //name 1
    }

//     ////////////////////////////  MultipleLangugage  ///////////////////////////////

    $items = [
        [
            'name' => ['ar' => 'name value 1 ar', 'en' => 'name value 1 en'],
            'email' => ['ar' => 'email value 1 ar', 'en' => 'email value 1 en'],
        ],
        [
            'name' => ['ar' => 'name value 2 ar', 'en' => 'name value 2 en'],
            'email' => ['ar' => 'email value 2 ar', 'en' => 'email value 2 en'],
        ],
        [
            'name' => ['ar' => 'name value 3 ar', 'en' => 'name value 3 en'],
            'email' => ['ar' => 'email value 3 ar', 'en' => 'email value 3 en'],
        ],
    ];

    setting('multiple_langugage')->save($items);

    foreach (setting('multiple_langugage')->get() as $item) {

        dd($item->name);
    }
    // https://www.udemy.com/share/101WXE3@wqSF03TKnGWxJ6w6eBDlkeaYV0AxbV_7k5rKLztjRjp3RzoFDdsRA6Z_tOOBmJkhgw==/
//     🚀I am a passionate and versatile software developer dedicated to crafting elegant and efficient solutions to complex problems. With a strong foundation in computer science and a love for coding, I have made it my mission to create software that not only meets the needs of users but also pushes the boundaries of innovation.🚀
// Born and raised in 🐣 Syria 🇸🇾, I discovered my passion for programming ⌨️ at an early age. This innate curiosity led me to pursue a Bachelor's degree 🎓 in Computer Science at SPU, where I gained a solid understanding of software development principles, algorithms, and data structures.

    return 'done';
    return view('welcome');
});
