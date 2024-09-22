<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;

class IndexController extends Controller
{
    public function index()
    {
    	return view('dashboard.admin.index');

    }//end of index

    public function changeLanguage(Language $language)
    {
        abort_if(!in_array($language->code, Language::pluck('code')->toArray()), 400);

        session()->put('code', $language->code);
        session()->put('dir', $language->dir);
        
        return redirect()->back();

    }//end of changeLanguage

}//end of controller