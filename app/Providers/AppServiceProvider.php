<?php

namespace App\Providers;

use App\Models\Contact;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();
        Paginator::useBootstrapFive();

        // Share data with dashboard sidebar
        View::composer('dashboard.layouts.sidebar', function ($view) {
            // Use the same cache key to avoid duplicate queries
            $unreadContactsCount = Cache::get('unread_contacts_count');
            if ($unreadContactsCount === null) {
                $unreadContactsCount = Cache::remember('unread_contacts_count', 300, function () {
                    return Contact::where('is_read', false)->count();
                });
            }
            $view->with('unreadContactsCount', $unreadContactsCount);
        });

        // Use SidebarComposer for cruise groups
        View::composer('dashboard.layouts.sidebar', \App\Http\View\Composers\SidebarComposer::class);
    }
}
