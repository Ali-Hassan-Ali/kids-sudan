<?php

//done
public function string()
{
	$items = 'name_logo.png';

	setting('logo')->save($items);

	setting('logo')->value;//name_logo.png
}

//done
public function single()
{
	$items = [
		'name'  => 'name value',
		'email' => 'email value',
	];

	setting('item')->save($items);

	setting('item')->name;//name value
}
//done
public function singleLanguage()
{
	$items = [
		'name'  => ['ar' => 'name ar', 'en' => 'name en'],
		'email' => ['ar' => 'email ar', 'en' => 'email en'],
	];

	setting('single_language')->save($items);

	setting('single_language')->name;//default lang 
}
//donw
public function singleMultiple()
{
	$items = [
		[
			'name'  => 'name value 1',
			'email' => 'email value 1',
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

	setting('item')->save($item);

	foreach (setting('item')->get() as $item) {
		dd($item->name); //name value 1
	}
}

//done
public function singleMultipleLangugage()
{
	$items = [
		[
			'name'  => ['ar' => 'name value 1 ar', 'en' => 'name value 1 en'],
			'email' => ['ar' => 'email value 1 ar' 'en' => 'email value 1 en'],
		],
		[
			'name'  => ['ar' => 'name value 2 ar', 'en' => 'name value 2 en'],
			'email' => ['ar' => 'email value 2 ar' 'en' => 'email value 2 en'],
		],
		[
			'name'  => ['ar' => 'name value 3 ar', 'en' => 'name value 3 en'],
			'email' => ['ar' => 'email value 3 ar' 'en' => 'email value 3 en'],
		]
	];

	setting('item')->save($items);

	foreach (setting('item')->get() as $item) {
		dd($item->name) // defult lang
		dd($item->name) // name value 1 ar
	}
}

//done
////multeple
public function Multiple()
{
	$items = [
		[
			'name' => 'name 1',
			'email' => 'email 1',
		],
		[
			'name' => 'name 2',
			'email' => 'email 2',
		],
		[
			'name' => 'name 3',
			'email' => 'email 3',
		],
	];

	setting('item')->save($item);

	foreach (setting('item')->get() as $key => $item) {
		
		dd($item->name); //name 1
	}
}
//done
public function MultipleLangugage()
{
	$items = [
		[
			'name' => ['ar' => 'name value 1 ar', 'en' => 'name value 1 en'],
			'email' => ['ar' => 'name value 1 ar', 'en' => 'name value 1 en'],
		],
		[
			'name' => ['ar' => 'name value 2 ar', 'en' => 'name value 2 en'],
			'email' => ['ar' => 'name value 2 ar', 'en' => 'name value 2 en'],
		],
		[
			'name' => ['ar' => 'name value 3 ar', 'en' => 'name value 3 en'],
			'email' => ['ar' => 'name value 3 ar', 'en' => 'name value 3 en'],
		],
	];

	setting('item')->save($items);

	foreach (setting('item')->get() as $item) {

		dd($item->name);//name value 1 en
	}

	setting('item')->get();
}