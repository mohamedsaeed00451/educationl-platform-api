<?php

namespace App\Http\Middleware;

use App\Http\Traits\MessageTrait;
use Closure;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateJwt
{
    use MessageTrait;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle($request, Closure $next, $guard): Response
    {

        try {

            auth()->shouldUse($guard);
            $user = JWTAuth::parseToken()->authenticate($request);

        } catch (\Exception $e) {

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->responseMessage(401, false, 'Invalid token');
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->responseMessage(401, false, 'Token expired');
            } else {
                return $this->responseMessage(401, false, 'Token not found');
            }
        }

        if (!$user) {
            return $this->responseMessage(401, false, 'Unauthorized');
        }

        return $next($request);

    }
}
