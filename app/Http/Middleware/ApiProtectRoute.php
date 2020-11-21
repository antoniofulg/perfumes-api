<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class ApiProtectRoute extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
         } catch (\Exception $e) {
           
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
               return response()->json(['message' => 'Token inválido']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
               return response()->json(['message' => 'Token não é mais válido']);
            }else{
               return response()->json(['message' => 'Token não encontrado']);
            }
        }
        return $next($request);
    }
}
