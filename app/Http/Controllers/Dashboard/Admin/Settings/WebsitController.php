<?php

namespace App\Http\Controllers\Dashboard\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Settings\WebsitRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;

class WebsitController extends Controller
{
    public function index(): View
    {
        abort_if(!permissionAdmin('read-settings'), 403);

        $breadcrumb = [['trans' => 'admin.settings.websit']];

    	return view('dashboard.admin.settings.website', compact('breadcrumb'));

    }//end of index

    public function store(WebsitRequest $request)
    {
        if(empty($request->get('websit_title'))) {

            saveTransSetting('websit_title', '');
            saveTransSetting('websit_keywords', '');
            saveTransSetting('websit_description', '');

        } else {

            saveTransSetting('websit_title', $request->websit_title);
            saveTransSetting('websit_description', $request->websit_description);
            saveTransSetting('websit_keywords', request()->websit_keywords);
        }

        if(request()->file('websit_logo')) {

            if(!empty(getSetting('websit_logo'))) {

                Storage::disk('public')->delete(getSetting('websit_logo'));
            }

            $logo = request()->file('websit_logo')->store('settings', 'public');

            saveSetting('websit_logo', $logo);
        }

        session()->flash('success', __('admin.messages.updated_successfully'));
        return redirect()->back();

    }//end of index

}//end of controller