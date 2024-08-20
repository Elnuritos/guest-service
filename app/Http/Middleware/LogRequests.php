<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequests
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

        try {

            Log::channel('redis')->info('Incoming Request', [
                'url' => $request->url(),
                'method' => $request->method(),
                'input' => $request->all(),
            ]);
        } catch (\Exception $e) {
            dd('Error logging to Redis:', $e->getMessage());
        }

        return $next($request);
    }
}
