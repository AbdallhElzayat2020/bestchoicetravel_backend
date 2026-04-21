<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'Dashboard',
                'slug' => 'dashboard.access',
                'description' => 'Access to dashboard',
                'status' => 'active',
            ],
            [
                'name' => 'Categories (Tours Management)',
                'slug' => 'categories.manage',
                'description' => 'Access Categories tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Sub Categories (Tours Management)',
                'slug' => 'sub-categories.manage',
                'description' => 'Access Sub Categories tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Users',
                'slug' => 'users.manage',
                'description' => 'Access Users tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Roles & Permissions',
                'slug' => 'roles.manage',
                'description' => 'Access Roles & Permissions tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Bookings (Section)',
                'slug' => 'bookings.menu',
                'description' => 'Access to Bookings section in sidebar',
                'status' => 'active',
            ],
            [
                'name' => 'Tour Bookings',
                'slug' => 'bookings.manage',
                'description' => 'Access Tour Bookings tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Nile Cruise Bookings',
                'slug' => 'bookings.cruise-vessels.manage',
                'description' => 'Access Nile Cruise Bookings tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Trip Planner Leads',
                'slug' => 'trip-planners.manage',
                'description' => 'Access Trip Planner Leads tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Nile Cruises (Section)',
                'slug' => 'cruise-catalog.manage',
                'description' => 'Access Nile Cruises section (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Categories (Nile Cruises)',
                'slug' => 'cruise-catalog.categories.manage',
                'description' => 'Access Cruise Categories tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Vessels (Nile Cruises)',
                'slug' => 'cruise-catalog.vessels.manage',
                'description' => 'Access Vessels tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Tours (Nile Cruises)',
                'slug' => 'cruise-catalog.programs.manage',
                'description' => 'Access Cruise Tours tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Menu Name',
                'slug' => 'settings.manage',
                'description' => 'Access Menu Name tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Main Categories (Categories Section)',
                'slug' => 'cruise-groups.manage',
                'description' => 'Access Main Categories tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'All Tours (Tours Section)',
                'slug' => 'tours.manage',
                'description' => 'Access All Tours tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Optional Excursions (Tours Section)',
                'slug' => 'tour-variants.manage',
                'description' => 'Access Optional Excursions tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Locations',
                'slug' => 'locations.menu',
                'description' => 'Access to Locations section in sidebar',
                'status' => 'active',
            ],
            [
                'name' => 'Countries',
                'slug' => 'countries.manage',
                'description' => 'Access Countries tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'States',
                'slug' => 'states.manage',
                'description' => 'Access States tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Live Highlights',
                'slug' => 'announcements.manage',
                'description' => 'Access Live Highlights tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'FAQs',
                'slug' => 'faqs.manage',
                'description' => 'Access FAQs tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Testimonials',
                'slug' => 'testimonials.manage',
                'description' => 'Access Testimonials tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Blogs',
                'slug' => 'blogs.manage',
                'description' => 'Access Blogs tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Blog Categories (Blogs)',
                'slug' => 'blog-categories.manage',
                'description' => 'Access Blog Categories tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Pages SEO',
                'slug' => 'pages.manage',
                'description' => 'Access Pages SEO tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'Home Sections',
                'slug' => 'site-sections.manage',
                'description' => 'Access Home Sections tab (all actions)',
                'status' => 'active',
            ],
            [
                'name' => 'All Sections (Home Sections)',
                'slug' => 'site-sections.index',
                'description' => 'Access All Sections tab',
                'status' => 'active',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }

        $keepSlugs = collect($permissions)->pluck('slug')->all();
        Permission::query()->whereNotIn('slug', $keepSlugs)->delete();

        $this->command->info('Permissions seeded successfully!');
    }
}
