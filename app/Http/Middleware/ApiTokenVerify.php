<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiTokenVerify
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
        $token = $request->header('Authorization');
        $response = Http::withHeaders([
            'Authorization' => $token
        ])->get(env('URL_API', 'https://api-report.lsskincare.id/api') . '/login-absen-check');
        if ($response->status() === 200) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
