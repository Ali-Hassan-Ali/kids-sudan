<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        // dd($request->route()->middleware());
        if (!$request->expectsJson()) {

            if (in_array('auth:admin', $request->route()->middleware())) {

                if (auth('admin')->check()) {

                    return 'fffffffffffffffff'; 
                    
                } else {

                    return redirect()->route('dashboard.admin.auth.login');
                }

            }//end if if admin auth

            return 'sssssssssssssssssssss'; 

        }//end of if

    }//end of fun

}//emd of class