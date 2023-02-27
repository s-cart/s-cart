<?php

namespace App\Pmo\Admin\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $redirectTo = sc_route_admin('admin.login');
        if (Auth::guard('admin')->guest() && !$this->shouldPassThrough($request)) {
            return redirect()->guest($redirectTo);
        }

        return $next($request);
    }

    /**
     * Determine if the request has a URI that should pass through verification.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function shouldPassThrough($request)
    {
        $routeName = $request->route()->getName();
        $excepts = [
            'admin.login',
            'admin.logout',
            'admin.forgot',
            'admin.register',
            'admin.password_reset',
            'admin.password_request',
        ];
        return in_array($routeName, $excepts);
    }
}
