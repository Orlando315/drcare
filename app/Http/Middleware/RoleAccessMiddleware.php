<?php

namespace App\Http\Middleware;

use Closure;

class RoleAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $minRole)
    {
      if( ! $request->user()->hasRole( $minRole ) ){
        return redirect( 'dashboard' );
      }

      return $next($request);
    }
}
