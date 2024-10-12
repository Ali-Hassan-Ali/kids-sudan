<?php

namespace App\Http\Controllers\Dashboard\Admin\Websites;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Websites\BannerRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;

class BannerController extends Controller
{
    public function index(): View
    {
        abort_if(!permissionAdmin('read-banner'), 403);

        $breadcrumb = [
            ['trans' => 'admin.models.websites'],
            ['trans' => 'admin.websites.banner']
        ];

    	return view('dashboard.admin.websites.banner.index', compact('breadcrumb'));

    }//end of index

    public function store(BannerRequest $request)
    {
        saveTransSetting('banner_welcome', $request->banner_welcome ?? '');
        saveTransSetting('banner_hello', $request->banner_hello ?? '');
        saveTransSetting('banner_name', $request->banner_name ?? '');
        saveTransSetting('banner_Skills', $request->banner_Skills ?? '');

        if(request()->file('banner_picture')) {

            if(!empty(getSetting('banner_picture'))) {

                Storage::disk('public')->delete(getSetting('banner_picture'));
            }

            $picture = request()->file('banner_picture')->store('website', 'public');

            saveSetting('banner_picture', $picture);

        }//end of if

        if (!empty($request->get('banner_rxperiences_title')[getLanguages('default')->code])) {

            $itemTitle  = [];
            $itemNumber = [];

            foreach($request->get('banner_rxperiences_title')[getLanguages('default')->code] as $indexName=>$name) {

                $itemsLangTitle  = [];
                $itemsLangNumber = [];

                foreach(getLanguages() as $index=>$language) {

                    $itemsLangTitle[$language->code]  = $request->get('banner_rxperiences_title')[$language->code][$indexName] ?? $request->get('banner_rxperiences_title')[getLanguages('default')->code][$indexName];
                    $itemsLangNumber[$language->code] = $request->get('banner_rxperiences_number')[$language->code][$indexName] ?? $request->get('banner_rxperiences_number')[getLanguages('default')->code][$indexName];;
                }

                $itemTitle[]  = $itemsLangTitle;
                $itemNumber[] = $itemsLangNumber;

            }

            $data = ['title' => $itemTitle, 'number' => $itemNumber];

            saveSetting('banner_rxperiences', json_encode($data));

        } else {

            saveSetting('banner_rxperiences', json_encode([]));

        }

        session()->flash('success', __('admin.messages.updated_successfully'));
        return redirect()->back();

    }//end of index

}//end of controller