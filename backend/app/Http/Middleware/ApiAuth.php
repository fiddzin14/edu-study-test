<?php

namespace App\Http\Middleware;

use App\Helpers\UtilitiesHelper;
use Closure;
use Illuminate\Http\Request;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('api-key') != null) {
            if ($request->header('api-key') == env('API_KEY', '123456')) {
                return $next($request);
            }
        }
        
        return response()->json(['response_code' => '01', 'description' => 'Invalid Api-key', 'data' => []]);
    }
}
