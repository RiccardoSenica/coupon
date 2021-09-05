<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if(!$token) {
            return response()->json([
                'error' => 'Token missing.'
            ], 401);
        }

        try {
            $auth = JWT::decode(explode(" ", $token)[1], env('JWT_SECRET'), ['HS256']);
            $request->auth = (array)$auth;
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'Token expired.'
            ], 400);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'Error decoding token.'
            ], 400);
        }

        return $next($request);
    }
}
