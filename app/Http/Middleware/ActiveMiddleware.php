<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ActiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth('web')->check()) {
            if (auth('web')->user()->active) {
                return $next($request);
            }

            $userName = auth('web')->user()->name;
            abort(403, "{$userName} был забанен на этом сайте");
        }

        return $next($request);
    }
}
