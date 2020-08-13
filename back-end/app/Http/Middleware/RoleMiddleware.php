<?php

namespace App\Http\Middleware;

use Closure;
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
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        /**
         * Define the moderator permission
         * A moderator can do everything a registered user can,
         * plus delete and update all articles and comments
         * @return mixed
         */
        if($user->roles->contains('marker', 'moderator')) {
          return $next($request);
        }

        /**
         * Define the registered user permission
         * A registered user can see all articles and comments,
         * plus create, update and destroy them
         * A registered user can only delete and update their own articles and comments
         * @return mixed
         */
        else if($user->roles->contains('marker', 'registered-user')) {
          //Allows the request to proceed only if the user id is the same as the $request id
          if($request->id) {
            if($request->id === $user->id) {
              return $next($request);
            }
            else {
              return response()->json(['Apenas moderadores podem editar e deletar outros usuarios!']);
            }
          }

          //Allows the request to proceed only if the user that is making the request owns the article
          if($user->articles) {
            $articles = $user->articles;
            foreach($articles as $article) {
              if($article->user_id === $user->id) {
                return $next($request);
              }
            }
          }
          else {
            return response()->json(['Voce nao eh dono desse artigo!']);
          }

          //Allows the request to proceed only if the user that is making the request owns the comment
          if($user->comments) {
            $comments = $user->comments;
            foreach($comments as $comment) {
              if($comment->user_id === $user->id) {
                return $next($request);
              }
            }
          }
          else {
            return response()->json(['Voce nao eh dono desse comentario!']);
          }
         }

        /**
         * If the user that is making the request does not have
         * the role of registered or moderator, the Middleware
         * prints the message to create an account
         */
        abort(404, 'Crie uma conta!');
    }
}
