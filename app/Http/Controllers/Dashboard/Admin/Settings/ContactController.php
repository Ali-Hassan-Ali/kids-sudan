<?php

namespace App\Http\Controllers\Dashboard\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Settings\ContactRequest;
use Illuminate\Contracts\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        abort_if(!permissionAdmin('read-settings'), 403);

        $breadcrumb = [['trans' => 'admin.settings.contact']];

    	return view('dashboard.admin.settings.contact', compact('breadcrumb'));

    }//end of index

    public function store(ContactRequest $request)
    {
        saveTransSetting('contact_phone', $request->contact_phone ?? '');
        saveTransSetting('contact_whatsapp', $request->contact_whatsapp ?? '');
        saveTransSetting('contact_email', $request->contact_email ?? '');
        saveTransSetting('contact_address', $request->contact_address ?? '');
        saveTransSetting('contact_address_link', $request->contact_address_link ?? '');

        session()->flash('success', __('admin.messages.updated_successfully'));
        return redirect()->back();

    }//end of index

}//end of controller