<?php

namespace App\Helpers;

if (! function_exists('setSidebarActive')) {
    /**
     * Return 'active' when the current route matches any of the given names.
     *
     * @param  string|array  $names
     * @param  string  $class
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

if (! function_exists('App\Helpers\vimeo_embed_src')) {
    /**
     * Build a Vimeo player URL for background embed from a page URL, player URL, or numeric ID.
     */
    function vimeo_embed_src(?string $url): ?string
    {
        if ($url === null || $url === '') {
            return null;
        }

        $trim = trim($url);
        if (preg_match('#vimeo\.com/(?:video/)?(\d+)#', $trim, $m)) {
            $id = $m[1];
        } elseif (preg_match('/^\d{5,12}$/', $trim)) {
            $id = $trim;
        } else {
            return null;
        }

        return 'https://player.vimeo.com/video/'.$id
            .'?badge=0&autopause=0&autoplay=1&loop=1&muted=1&title=0&byline=0&portrait=0';
    }
}
