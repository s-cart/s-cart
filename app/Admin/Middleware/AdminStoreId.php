<?php

namespace App\Admin\Middleware;

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
        $adminStoreId = null;
        if (!Session::has('adminStoreId')) {
            if(\Admin::user() && count($arrStoreId = \Admin::user()->listStoreId())) {
                if(in_array(0, $arrStoreId)) {
                    $adminStoreId = $arrStoreId[1];
                } else {
                    $adminStoreId = $arrStoreId[0];
                }
            }
        } else {
            $adminStoreId = session('adminStoreId');
        }
        session(['adminStoreId' => $adminStoreId]);
        return $next($request);
    }
}
