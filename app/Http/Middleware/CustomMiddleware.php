<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if ($request->path() !== 'categories') {
        //     abort(404);
        // }
        // return $next($request);

        $path = $request->path();

        if (strpos($path, 'categories') !== false) {
            return $next($request);
        }

        abort(404);
    }
}
