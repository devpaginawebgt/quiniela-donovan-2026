<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        if ( !$request->expectsJson() ) {
            
            return $this->errorResponse("El header 'Accept' debe incluir 'application/json'", 406);

        }

        $apiKey = $request->bearerToken();

        if ( empty($apiKey) ) {

            return $this->errorResponse('No tienes permiso para acceder a este recurso', 401);

        }

        if ( $apiKey !== config('quiniela.api_key') ) {

            return $this->errorResponse('No tienes permiso para acceder a este recurso', 401);

        }

        return $next($request);
    }
}
