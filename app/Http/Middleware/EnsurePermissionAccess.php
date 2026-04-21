<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePermissionAccess
{
    /**
     * Ensure user has at least one of the given permissions.
     */
    public function handle(Request $request, Closure $next, string $permissions): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        if ($user->isAdmin()) {
            return $next($request);
        }

        $permissionSlugs = array_filter(array_map('trim', explode('|', $permissions)));

        if (empty($permissionSlugs) || ! $user->hasAnyPermission($permissionSlugs)) {
            abort(403);
        }

        return $next($request);
    }
}

