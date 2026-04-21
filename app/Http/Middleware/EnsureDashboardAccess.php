<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDashboardAccess
{
    /**
     * Allow only admins or users with dashboard access permission.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        // Allow admin, explicit dashboard access, or any assigned active permission.
        $hasDashboardEntryAccess = $user->isAdmin()
            || $user->hasPermission('dashboard.access')
            || $user->getPermissions()->isNotEmpty();

        if (! $hasDashboardEntryAccess) {
            abort(403);
        }

        return $next($request);
    }
}

