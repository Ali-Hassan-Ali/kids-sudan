<?php

namespace App\Http\Controllers\Dashboard\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Auth\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Admin;

class LoginController extends Controller
{
    public function index(): RedirectResponse | View
    {
        if (auth('admin')->check()) {

            return redirect()->route('dashboard.admin.index');

        } else {

            return view('dashboard.admin.auth.login');
        }

    }//end of index

    public function store(LoginRequest $request)
    {
        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $request->merge([
            $login_type => $request->input('login')
        ]);

        $credentials = $request->only($login_type, 'password');

        if (auth('admin')->attempt($credentials, request()->has('remember'))) {

            session()->flash('success', __('admin.messages.login_successfully'));

            return redirect()->route('dashboard.admin.index');

        } else {

            return redirect()->back()->with(['password' => __('auth.password_invalid')])->withInput();

        }//end of if

    }//end of index

    public function logout()
    {
        auth('admin')->logout();

        return redirect()->route('dashboard.admin.auth.login.index');

    }//end of fun

}//end of controller
