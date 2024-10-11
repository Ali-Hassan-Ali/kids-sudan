<?php

namespace App\Http\Controllers\Dashboard\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Settings\FaqRequest;
use Illuminate\Contracts\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        abort_if(!permissionAdmin('read-settings'), 403);

        $breadcrumb = [['trans' => 'admin.settings.faq']];

    	return view('dashboard.admin.settings.faq.index', compact('breadcrumb'));

    }//end of index

    public function store(FaqRequest $request)
    {
        if (!empty($request->get('faq_title')[getLanguages('default')->code])) {

            $itemTitle       = [];
            $itemDescription = [];
            $itemStatus      = [];

            foreach($request->get('faq_title')[getLanguages('default')->code] as $indexName=>$name) {

                $itemsLangTitle        = [];
                $itemsLangDescription  = [];
                $itemsLangStatus       = [];

                foreach(getLanguages() as $index=>$language) {

                    $itemsLangTitle[$language->code]                = $request->get('faq_title')[$language->code][$indexName] ?? $request->get('faq_title')[getLanguages('default')->code][$indexName];
                    $itemsLangDescription[$language->code]          = $request->get('faq_description')[$language->code][$indexName] ?? $request->get('faq_description')[getLanguages('default')->code][$indexName];;
                    $itemsLangStatus[getLanguages('default')->code] = $request->get('faq_status')[getLanguages('default')->code][$indexName] ?? $request->get('faq_status')[getLanguages('default')->code][$indexName];;
                    
                }//end pf each

                $itemTitle[]       = $itemsLangTitle;
                $itemDescription[] = $itemsLangDescription;
                $itemStatus[]      = $itemsLangStatus;

            }//end pf each

            $data = ['title' => $itemTitle, 'description' => $itemDescription, 'status' => $itemStatus];

            saveSetting('faq', json_encode($data));

        } else {

            saveSetting('faq', json_encode([]));

        }//end of check

        session()->flash('success', __('admin.global.updated_successfully'));
        return redirect()->back();

    }//end of store

}//end of controller