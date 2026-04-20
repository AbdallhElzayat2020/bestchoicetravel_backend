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
                'name' => 'Dashboard Access',
                'slug' => 'dashboard.access',
                'description' => 'Access to dashboard',
                'status' => 'active',
            ],
            [
                'name' => 'Categories Management',
                'slug' => 'categories.manage',
                'description' => 'Full access to categories management',
                'status' => 'active',
            ],
            [
                'name' => 'Categories View',
                'slug' => 'categories.view',
                'description' => 'View categories',
                'status' => 'active',
            ],
            [
                'name' => 'Categories Create',
                'slug' => 'categories.create',
                'description' => 'Create new categories',
                'status' => 'active',
            ],
            [
                'name' => 'Categories Edit',
                'slug' => 'categories.edit',
                'description' => 'Edit existing categories',
                'status' => 'active',
            ],
            [
                'name' => 'Categories Delete',
                'slug' => 'categories.delete',
                'description' => 'Delete categories',
                'status' => 'active',
            ],
            [
                'name' => 'Sub Categories Management',
                'slug' => 'sub-categories.manage',
                'description' => 'Full access to sub categories management',
                'status' => 'active',
            ],
            [
                'name' => 'Sub Categories View',
                'slug' => 'sub-categories.view',
                'description' => 'View sub categories',
                'status' => 'active',
            ],
            [
                'name' => 'Sub Categories Create',
                'slug' => 'sub-categories.create',
                'description' => 'Create new sub categories',
                'status' => 'active',
            ],
            [
                'name' => 'Sub Categories Edit',
                'slug' => 'sub-categories.edit',
                'description' => 'Edit existing sub categories',
                'status' => 'active',
            ],
            [
                'name' => 'Sub Categories Delete',
                'slug' => 'sub-categories.delete',
                'description' => 'Delete sub categories',
                'status' => 'active',
            ],
            [
                'name' => 'Users Management',
                'slug' => 'users.manage',
                'description' => 'Full access to users management',
                'status' => 'active',
            ],
            [
                'name' => 'Roles Management',
                'slug' => 'roles.manage',
                'description' => 'Full access to roles management',
                'status' => 'active',
            ],
            [
                'name' => 'Permissions Management',
                'slug' => 'permissions.manage',
                'description' => 'Full access to permissions management',
                'status' => 'active',
            ],
            [
                'name' => 'Bookings Management',
                'slug' => 'bookings.manage',
                'description' => 'Manage tour bookings',
                'status' => 'active',
            ],
            [
                'name' => 'Cruise Vessel Enquiries Management',
                'slug' => 'bookings.cruise-vessels.manage',
                'description' => 'Manage reserved vessels enquiries',
                'status' => 'active',
            ],
            [
                'name' => 'Trip Planner Management',
                'slug' => 'trip-planners.manage',
                'description' => 'Manage trip planner requests',
                'status' => 'active',
            ],
            [
                'name' => 'Cruise Catalog Management',
                'slug' => 'cruise-catalog.manage',
                'description' => 'Full access to cruise catalog',
                'status' => 'active',
            ],
            [
                'name' => 'Cruise Catalog Categories Management',
                'slug' => 'cruise-catalog.categories.manage',
                'description' => 'Manage cruise catalog categories',
                'status' => 'active',
            ],
            [
                'name' => 'Cruise Catalog Vessels Management',
                'slug' => 'cruise-catalog.vessels.manage',
                'description' => 'Manage cruise catalog vessels',
                'status' => 'active',
            ],
            [
                'name' => 'Cruise Catalog Programs Management',
                'slug' => 'cruise-catalog.programs.manage',
                'description' => 'Manage cruise catalog programs',
                'status' => 'active',
            ],
            [
                'name' => 'Settings Management',
                'slug' => 'settings.manage',
                'description' => 'Manage website settings',
                'status' => 'active',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }

        $this->command->info('Permissions seeded successfully!');
    }
}
