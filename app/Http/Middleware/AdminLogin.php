<?php

namespace Share\Http\Middleware;

use Closure;

class AdminLogin
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
        define('EmpireCMSAdmin','1');
        $lur=is_login();
        return $next($request);
    }
}
