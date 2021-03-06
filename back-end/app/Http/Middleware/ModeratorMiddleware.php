<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ModeratorMiddleware
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
      $user = Auth::user();
      if($user->roles->contains('marker', 'moderator')) {
        return $next($request);
      }
      else {
        return response()->json(['Somente o moderador pode realizar essa acao!']);
      }
    }
}
