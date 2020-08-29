<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AdminStore;
use Illuminate\Support\Str;

class CheckDomain
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
        //Check domain exist
        $domain = Str::finish(str_replace(['http://','https://'], '', url('/')), '/');
        $arrDomain = AdminStore::getDomain();
        if (!in_array($domain, $arrDomain) && sc_config_global('domain_strict') ) {
            echo view('deny_domain')->render();
            exit();
        }
        return $next($request);
    }
}
