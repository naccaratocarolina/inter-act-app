<?php

namespace App\Http\Middleware;

use Closure;

class CORS
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
      // acess  the answer
      $resposta = $next($request);
      // add headers
      $resposta->header('Access-Control-Allow-Origin', '*');
      $resposta->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
      $resposta->header('Access-Control-Allow-Headers', 'Authorization, Content-Type');
      //return the $resposta
      return $resposta;
    }
}