<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Closure;
use Illuminate\Support\Facades\Redirect;

class SecurityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Step 1: you can use the following to get the route URI $request->path() or
        // we can also use $request->is()
        $path = $request->path();
        Log::info("Entering My Security Middle Ware in handle() at path: ".$path);
        
        //Step 2: Run the business rules that check for the URI's that you do not need to secure.
        $secureCheck = true;
        if((session()->get('user') == true) || $request->is('/') || $request->is('doLogin') || $request->is('suspended') || $request->is('register') || $request->is('login'))
        {
            $secureCheck = false;
        }
        Log::info($secureCheck ? "Security Middleware in handle()... Needs Security" : "Security Middleware in handle()... No Security Required");
        //Step 3: If entering a secure URI with no security token then redirect to the login page.
        
        if(( $request->is('showalljobs') ||$request->is('roles') || $request->is('/roles') || $request->is('newaffinitygroup') || $request->is('admin') || $request->is('newjob')) && (session()->get('isAdmin') == false))
        {
            $secureCheck = true;
        }
        if($secureCheck)
        {
            //$message = "You do not have privilege to access that page!";
            Log::info("Leaving My Security Middleware in handle() doing a redirect to login or home.");
            if (session()->get('user') == true)
                return redirect('/home');
            else
                return redirect('/login');
        }
        return $next($request);
    }
}
