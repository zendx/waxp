<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCentralDomain
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $baseDomain = env('TENANCY_BASE_DOMAIN', 'waxp.test');

        if ($host !== $baseDomain) {
            abort(404);
        }

        return $next($request);
    }
}
