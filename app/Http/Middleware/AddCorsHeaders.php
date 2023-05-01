<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddCorsHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', 'http://localhost:5173');

        $response->header('Access-Control-Allow-Methods', '*');
        $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        return $response;
    }
}
