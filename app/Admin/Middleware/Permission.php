<?php

namespace App\Admin\Middleware;

use App\Admin\Admin;
use App\Admin\Permission as Checker;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Permission
{
    /**
     * @var string
     * Example midleware roles admin.permission:allow,administrator,editor
     */
    protected $middlewarePrefix = 'admin.permission:';

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param array                    $args
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next, ...$args)
    {
        if (!Admin::user() || !empty($args) || $this->shouldPassThrough($request) || Admin::user()->isAdministrator()) {
            return $next($request);
        }

        // Allow access route
        if ($this->routeDefaultPass($request)) {
            return $next($request);
        }

        //Check middware in route
        if ($this->checkRoutePermission($request)) {
            return $next($request);
        }

        //Group view all
        // this group can view all path, but cannot change data
        if (Admin::user()->isViewAll()) {
            if ($request->method() == 'GET'
                && !collect($this->viewWithout())->contains($request->path())
            ) {
                return $next($request);
            } else {
                if (!request()->ajax()) {
                    return redirect()->route('admin.deny')->with(['url' => $request->url(), 'method' => $request->method()]);
                } else {
                    return Checker::error();
                }
            }
        }

        if (!Admin::user()->allPermissions()->first(function ($permission) use ($request) {
            //Method shouldPassThrough in \App\Admin\Models\AdminPermission ->shouldPassThrough
            return $permission->shouldPassThrough($request);
        })) {
            if (!request()->ajax()) {
                return redirect()->route('admin.deny')->with(['url' => $request->url(), 'method' => $request->method()]);
            } else {
                return Checker::error();
            }
        }
        return $next($request);
    }

    /**
     * If the route of current request contains a middleware prefixed with 'admin.permission:',
     * then it has a manually set permission middleware, we need to handle it first.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function checkRoutePermission(Request $request)
    {
        if (!$middleware = collect($request->route()->middleware())->first(function ($middleware) {
            return Str::startsWith($middleware, $this->middlewarePrefix);
        })) {
            return false;
        }
        $args = explode(',', str_replace($this->middlewarePrefix, '', $middleware));

        $method = array_shift($args);

        if (!method_exists(Checker::class, $method)) {
            throw new \InvalidArgumentException("Invalid permission method [$method].");
        }

        call_user_func_array([Checker::class, $method], [$args]);

        return true;
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
        $routePath = $request->path();
        $routeName = $request->route()->getName();
        $exceptsPAth = [
            SC_ADMIN_PREFIX . '/auth/login',
            SC_ADMIN_PREFIX . '/auth/logout',
            SC_ADMIN_PREFIX . '/theme/white',
        ];
        $exceptsName = [
            'admin.theme'
        ];
        return in_array($routePath, $exceptsPAth) || in_array($routeName, $exceptsName);
    }

/*
Check route defualt allow access
 */
    public function routeDefaultPass($request)
    {
        $routeName = $request->route()->getName();
        $allowRoute = ['admin.deny', 'admin.locale', 'admin.home'];
        return in_array($routeName, $allowRoute);
    }

    public function viewWithout()
    {
        return [
            SC_ADMIN_PREFIX . '/uploads/delete',
            SC_ADMIN_PREFIX . '/uploads/newfolder',
            SC_ADMIN_PREFIX . '/uploads/domove',
            SC_ADMIN_PREFIX . '/uploads/rename',
            SC_ADMIN_PREFIX . '/uploads/resize',
            SC_ADMIN_PREFIX . '/uploads/doresize',
            SC_ADMIN_PREFIX . '/uploads/cropimage',
            SC_ADMIN_PREFIX . '/uploads/crop',
            SC_ADMIN_PREFIX . '/uploads/move',
        ];
    }

}
