<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SetTenantFromHost
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $baseDomain = env('TENANCY_BASE_DOMAIN', 'waxp.test');

        if ($host === $baseDomain) {
            DB::setDefaultConnection('central');
            return $next($request);
        }

        if (!str_ends_with($host, '.' . $baseDomain)) {
            abort(404);
        }

        $tenant = Tenant::query()
            ->where('domain', $host)
            ->where('is_active', true)
            ->first();

        if (!$tenant) {
            abort(404);
        }

        config(['database.connections.tenant.database' => $tenant->db_name]);
        DB::purge('tenant');
        DB::reconnect('tenant');
        DB::setDefaultConnection('tenant');
        app()->instance(Tenant::class, $tenant);

        return $next($request);
    }
}
