<?php

namespace App\Http\Controllers\Dashboard\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Settings\MetaRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;

class MetaController extends Controller
{
    public function index(): View
    {
        abort_if(!permissionAdmin('read-settings'), 403);

        $breadcrumb = [['trans' => 'admin.settings.meta']];

    	return view('dashboard.admin.settings.meta', compact('breadcrumb'));

    }//end of index

    public function store(MetaRequest $request)
    {
        if(empty($request->get('meta_title'))) {

            saveTransSetting('meta_title', '');
            saveTransSetting('meta_keywords', '');
            saveTransSetting('meta_description', '');

        } else {

            saveTransSetting('meta_title', $request->meta_title);
            saveTransSetting('meta_keywords', $request->meta_keywords);
            saveTransSetting('meta_description', $request->meta_description);
        }

        if(request()->file('meta_logo')) {

            if(!empty(getSetting('meta_logo'))) {

                Storage::disk('public')->delete(getSetting('meta_logo'));
            }

            $logo = request()->file('meta_logo')->store('settings', 'public');

            saveSetting('meta_logo', $logo);
        }

        session()->flash('success', __('admin.messages.updated_successfully'));
        return redirect()->back();

    }//end of index

}//end of controller