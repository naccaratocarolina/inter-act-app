<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
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
        foreach($roles as $role) { //iterates the role list
          if(auth()->user()->hasRole($role)) { //if the user has the role
            return $next($request); //request approved
          }
        }

        abort(404); //if the user doesn't have the role, the request is not approved
    }
}
