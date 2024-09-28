<?php

namespace App\Http\Controllers\Dashboard\Admin\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Website\BannerRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;

class BannerController extends Controller
{
    public function index(): View
    {
        abort_if(!permissionAdmin('read-settings'), 403);

        $breadcrumb = [['trans' => 'admin.settings.banner']];

    	return view('dashboard.admin.settings.banner', compact('breadcrumb'));

    }//end of index

    public function store(BannerRequest $request)
    {
        if(empty($request->get('banner_title'))) {

            saveTransSetting('banner_title', '');
            saveTransSetting('banner_keywords', '');
            saveTransSetting('banner_description', '');

        } else {

            saveTransSetting('banner_title', $request->banner_title);
            saveTransSetting('banner_keywords', $request->banner_keywords);
            saveTransSetting('banner_description', $request->banner_description);
        }

        if(request()->file('banner_logo')) {

            if(!empty(getSetting('banner_logo'))) {

                Storage::disk('public')->delete(getSetting('banner_logo'));
            }

            $logo = request()->file('banner_logo')->store('website', 'public');

            saveSetting('banner_logo', $logo);
        }

        session()->flash('success', __('admin.messages.updated_successfully'));
        return redirect()->back();

    }//end of index

}//end of controller