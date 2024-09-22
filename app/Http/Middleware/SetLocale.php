<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if(getLanguages()->count()) {

            if(!session('code')) {
                session('dir') ?? session()->put('dir', getLanguages('default')?->dir);
                session('code') ?? session()->put('code', getLanguages('default')->code);
            }

            app()->setLocale(session('code'));

        } else {

            app()->setLocale(app()->getLocale());

        }//end of check

        !session('them-mode') ? session()->put('them-mode', 'dark') : '';

        return $next($request);

    }//end of handle

}//end of class
