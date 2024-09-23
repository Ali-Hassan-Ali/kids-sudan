<?php

namespace App\Http\Controllers\Dashboard\Admin\Auth\Account;

use App\Http\Requests\Dashboard\Admin\Auth\Account\ProfileRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Admin;

class ProfileController extends Controller
{
    public function edit(): View
    {
        abort_if(!auth('admin')->check(), 403);

        $breadcrumb = [['trans' => 'admin.auth.edit_profile']];
        $admin      = auth('admin')->user();

        return view('dashboard.admin.auth.accounts.edit_profile', compact('admin', 'breadcrumb'));

    }//end of edit page

    public function update(ProfileRequest $request, Admin $admin): RedirectResponse
    {
        $requestData = request()->except(['image']);

        if(request()->has('image')) {

            $admin->image ? Storage::disk('public')->delete($admin->image) : '';

            $requestData['image'] = request()->file('image')->store('admins', 'public');

        }

        session()->flash('success', __('admin.messages.updated_successfully'));

        $admin->update($requestData);

        return redirect()->back();
        
    }//end of update

}//end of controller