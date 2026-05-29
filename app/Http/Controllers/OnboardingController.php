<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user && $user->tenant_id) {
            return $this->redirectToTenant($user->tenant->domain);
        }

        return view('onboarding.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $baseDomain = env('TENANCY_BASE_DOMAIN', 'waxp.test');

        $validated = $request->validate([
            'store_name' => ['required', 'string', 'max:255'],
            'subdomain' => ['required', 'string', 'alpha_dash', 'min:3', 'max:30'],
        ]);

        $subdomain = Str::lower($validated['subdomain']);
        $domain = $subdomain . '.' . $baseDomain;
        $dbName = $this->tenantDatabaseName($subdomain);

        $existing = Tenant::query()
            ->where('domain', $domain)
            ->orWhere('db_name', $dbName)
            ->first();

        if ($existing) {
            return back()->withErrors([
                'subdomain' => 'That subdomain is already taken.',
            ])->withInput();
        }

        $this->createTenantDatabase($dbName);

        $tenant = Tenant::create([
            'name' => $validated['store_name'],
            'slug' => $subdomain,
            'domain' => $domain,
            'db_name' => $dbName,
            'is_active' => true,
        ]);

        $user = $request->user();
        $user->tenant_id = $tenant->id;
        $user->save();

        $this->migrateTenantDatabase($dbName);

        return $this->redirectToTenant($tenant->domain);
    }

    private function createTenantDatabase(string $dbName): void
    {
        $safeName = $this->sanitizeDatabaseName($dbName);
        $sql = "CREATE DATABASE IF NOT EXISTS `{$safeName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
        DB::connection('central')->statement($sql);
    }

    private function migrateTenantDatabase(string $dbName): void
    {
        config(['database.connections.tenant.database' => $dbName]);
        DB::purge('tenant');
        DB::reconnect('tenant');

        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path' => 'database/migrations/tenant',
            '--force' => true,
        ]);
    }

    private function tenantDatabaseName(string $subdomain): string
    {
        return 'waxp_tenant_' . $subdomain;
    }

    private function sanitizeDatabaseName(string $dbName): string
    {
        $safe = preg_replace('/[^a-z0-9_]+/i', '', $dbName) ?? '';
        if ($safe === '' || $safe !== $dbName) {
            abort(422, 'Invalid tenant database name.');
        }

        return $safe;
    }

    private function redirectToTenant(string $domain): RedirectResponse
    {
        $scheme = env('APP_SCHEME', 'http');

        return redirect()->away($scheme . '://' . $domain . '/dashboard');
    }
}
