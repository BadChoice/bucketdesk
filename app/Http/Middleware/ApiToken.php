<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class ApiToken
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
        $token = config('app.api_token');
        if (!request()->header('Authorization') == "Bearer $token") {
            return response("Unauthorized", Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
