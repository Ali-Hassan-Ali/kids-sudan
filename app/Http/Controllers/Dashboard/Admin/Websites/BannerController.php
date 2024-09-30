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
            ['trans' => 'admin.models.websits'],
            ['trans' => 'admin.websits.banner']
        ];

    	return view('dashboard.admin.websits.banner', compact('breadcrumb'));

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
        }

        session()->flash('success', __('admin.messages.updated_successfully'));
        return redirect()->back();

    }//end of index

}//end of controller