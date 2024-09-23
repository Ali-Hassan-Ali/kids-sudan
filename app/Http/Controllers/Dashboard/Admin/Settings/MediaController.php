<?php

namespace App\Http\Controllers\Dashboard\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Settings\MediaRequest;
use Illuminate\Contracts\View\View;

class MediaController extends Controller
{
    public function index(): View
    {
        abort_if(!permissionAdmin('read-settings'), 403);

        $breadcrumb = [['trans' => 'admin.settings.media']];

    	return view('dashboard.admin.settings.media', compact('breadcrumb'));

    }//end of index

    public function store(MediaRequest $request)
    {
        saveTransSetting('media_facebook', $request->media_facebook ?? '');
        saveTransSetting('media_twitter', $request->media_twitter ?? '');
        saveTransSetting('media_instagram', $request->media_instagram ?? '');
        saveTransSetting('media_video_links', $request->media_video_links ?? '');
        saveTransSetting('media_google_play', $request->media_google_play ?? '');
        saveTransSetting('media_apple_store', $request->media_apple_store ?? '');

        session()->flash('success', __('admin.messages.updated_successfully'));
        return redirect()->back();

    }//end of index

}//end of controller