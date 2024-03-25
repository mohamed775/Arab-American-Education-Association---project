<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPassword
{
    
    public function handle(Request $request, Closure $next): Response
    {
        if($request->api_password !== env('API_PASSWORD' , 'b2IVqtnyn8Q')){
            return response()->json(['message' => 'Unauthenticated']);
        }
        return $next($request);
    }
}
