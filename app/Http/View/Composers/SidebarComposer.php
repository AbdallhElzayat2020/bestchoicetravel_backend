<?php

namespace App\Http\View\Composers;

use App\Models\CruiseGroup;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Bind data to the view.
     *
     * Note: Statistics are now only shown on dashboard home page, not in sidebar
     * to reduce database queries and improve performance.
     */
    public function compose(View $view): void
    {
        // Load cruise groups dynamically from database (cached)
        $cruiseGroups = Cache::remember('cruise_groups_sidebar', 3600, function () {
            return CruiseGroup::active()
                ->orderBy('sort_order')
                ->get();
        });

        $view->with('cruiseGroups', $cruiseGroups);
    }
}

