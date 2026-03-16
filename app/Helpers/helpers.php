<?php

namespace App\Helpers;


if (! function_exists('setSidebarActive')) {
    /**
     * Return 'active' when the current route matches any of the given names.
     *
     * @param  string|array  $names
     * @param  string  $class
     * @return string
     */
    function setSidebarActive(array $routes, string $activeClasses = 'active open', string $inactiveClasses = ''): string
    {

        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return $activeClasses;
            }
        }
        return $inactiveClasses;
    }
}
