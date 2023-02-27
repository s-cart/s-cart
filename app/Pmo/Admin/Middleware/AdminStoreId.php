<?php

namespace App\Pmo\Admin\Middleware;

use Closure;
use Session;

class AdminStoreId
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
        if (\Admin::user()) {
            session(['adminStoreId' => SC_ID_ROOT]);
        } else {
            session()->forget('adminStoreId');
        }
        return $next($request);
    }
}
