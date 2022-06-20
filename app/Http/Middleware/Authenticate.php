<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
      
            if ($request->is('user*')) {
                if (! $request->expectsJson()) {
                    return route('login');
                }
            } else if ($request->is('admin*'))  {
                if (! $request->expectsJson()) {
                    return route('admin.show.login');
                }
            }
   
    }
}
