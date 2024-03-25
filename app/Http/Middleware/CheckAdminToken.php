<?php

namespace App\Http\Middleware;

use App\Http\Traits\GeneralTrait;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAdminToken
{
    use GeneralTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = null ;

        try{
            $user = JWTAuth::parseToken()->authenticate();
        }catch(\Exception $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException)
            {
                return $this->returnError('E3001','invalid_Token');
            }
            elseif($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException)
            {
                return $this->returnError('E3001','TokenExpiredException');
            }
            else{
                return $this->returnError('E3001','notfound');
            }
        }

        if(!$user)
             return $this->returnError('E3001','unAuthnticated');
        return $next($request);
    }
}
