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

        $breadcrumb = [['trans' => 'admin.models.settings'], ['trans' => 'admin.settings.media']];

    	return view('dashboard.admin.settings.social-links.index', compact('breadcrumb'));

    }//end of index

    public function store(MediaRequest $request)
    {
        if (!empty($request->get('social_types')) && !empty($request->get('social_links'))) {
            
            $social = [];

            foreach ($request->get('social_types') as $index=>$type) {

                $social[] = [
                    'type'  => $type,
                    'icon'  => $request->get('social_icons')[$index] ?? '',
                    'link'  => $request->get('social_links')[$index] ?? '',
                    'status'=> $request->get('social_status')[$index] ? 1 : 0,
                ];

            }

            saveSetting('social_links', $social ?? []);
        }

        session()->flash('success', __('admin.messages.updated_successfully'));
        return redirect()->back();

    }//end of index

}//end of controller