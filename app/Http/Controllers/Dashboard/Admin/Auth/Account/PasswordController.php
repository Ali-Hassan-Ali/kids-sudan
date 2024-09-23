<?php

namespace App\Http\Controllers\Dashboard\Admin\Auth\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Auth\Account\PasswordRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PasswordController extends Controller
{
	public function edit(): View
    {
        abort_if(!auth('admin')->check(), 403);

        $breadcrumb = [['trans' => 'admin.auth.edit_password']];

        return view('dashboard.admin.auth.accounts.edit_password', compact('breadcrumb'));

    }//end pf edit password

    public function update(PasswordRequest $request): RedirectResponse
    {
        $admin = auth()->user();

        $admin->update([
            'password' => request('new_password') 
        ]);

        session()->flash('success', __('admin.messages.updated_successfully'));

        return redirect()->back();

    }//end of update password

}//end of controller
