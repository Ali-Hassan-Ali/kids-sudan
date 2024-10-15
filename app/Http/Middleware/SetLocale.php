<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if (getLanguages()->count()) {

            session()->put('dir', session('dir', getLanguages('default')?->dir));
            session()->put('code', session('code', getLanguages('default')->code));

            app()->setLocale(session('code'));
        }

        session()->put('them-mode', session('them-mode', 'dark'));

        return $next($request);

    }//end of handle

}//end of class
