<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Auth;

class CheckOwnerMiddleware
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

      else if($user->roles->contains('marker', 'registered-user')) {
        if($user->isArticleOwner($request->id) || $user->isCommentOwner($request->id)) {
          return $next($request);
        }
        return response()->json('Esse comentario ou artigo nao eh seu!', 401);
       }
    }
}
