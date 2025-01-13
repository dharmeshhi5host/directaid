<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class CheckUser
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
        try{
            $user = JWTAuth::parseToken()->authenticate();
            if($user){
                return $next($request);
            }else{
                return response()->json(['success' => false, 'message' => 'Not Allowed'], 400);
            }
        } catch(\Exception $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['success' => false, 'message' => 'Token is Invalid'], 400);
            } else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['success' => false, 'message' => 'Token is Expired'], 400);
            } else{
                return response()->json(['success' => false, 'message' => 'Authorization Token not found'], 400);
            }
        }
    }
}
