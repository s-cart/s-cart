<?php

namespace App\Pmo\Front\Middleware;

use Closure;

class EmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|null
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        $arrExclude = [
            'customer.verify',
            'customer.verify_resend',
            'customer.verify_process',
        ];
        if ($request->user()->hasVerifiedEmail()) {
            if (!in_array($request->route()->getName(), $arrExclude)) {
                return redirect()->guest(sc_route('customer.verify'));
            }
        } else {
            if (in_array($request->route()->getName(), $arrExclude)) {
                return redirect(sc_route('customer.index'));
            }
        }

        return $next($request);
    }
}
