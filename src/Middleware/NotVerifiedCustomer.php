<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class NotVerifiedCustomer
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

        if (Auth::guard('customer')->check() !== true || Auth::guard('customer')->user()->verified == 0) {
            return redirect('/');
        }
        return $next($request);
    }
}
