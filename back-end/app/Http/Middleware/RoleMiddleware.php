<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    //check if user is authorizat do this action
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if($user->roles->contains('marker', 'moderator')) {
          return $next($request);
        }

        else if($user->roles->contains('marker', 'registered-user')) {
          if (!isset($request->id) || $user->id != $request->id || $request->id == NULL) {
            return response()->json('Apenas o moderador pode editar ou deletar outro usuario!', 401);
          }
          return $next($request);
         }
    }
}
