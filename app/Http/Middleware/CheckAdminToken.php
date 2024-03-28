<?php

namespace App\Http\Middleware;

use App\Http\Traits\GeneralTrait;
use App\Models\admin;
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

        try{
            if (isset($request->token) && $request->token != null)
            {
                $admin = admin::where('token', $request->token)->first();
                if($admin != null)
                    return $next($request);
            }
            return response()->json([
                'error' => 'Unauthenticate Admin'
                ], 
                401);    
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

    }
}
