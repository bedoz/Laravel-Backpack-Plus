<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminMiddleware
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
        if (\Auth::user() && !\Auth::user()->can('access backend'))
            return response(trans('backpack::base.unauthorized'),401);
        return $next($request);
    }
}
