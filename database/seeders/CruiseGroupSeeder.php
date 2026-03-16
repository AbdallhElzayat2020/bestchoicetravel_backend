<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CruiseGroup;

class CruiseGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'name' => 'Egypt Tours',
                'slug' => 'egypt-tours',
                'group_key' => 'egypt-tours',
                'sort_order' => 1,
                'status' => 'active',
            ],
            [
                'name' => 'Nile Cruises',
                'slug' => 'nile-cruises',
                'group_key' => 'nile-cruises',
                'sort_order' => 2,
                'status' => 'active',
            ],
            [
                'name' => 'Egypt Day Tours',
                'slug' => 'egypt-day-tours',
                'group_key' => 'egypt-day-tours',
                'sort_order' => 3,
                'status' => 'active',
            ],
            [
                'name' => 'Egypt & Beyond',
                'slug' => 'egypt-and-beyond',
                'group_key' => 'egypt-and-beyond',
                'sort_order' => 4,
                'status' => 'active',
            ],
        ];

        foreach ($groups as $group) {
            CruiseGroup::updateOrCreate(
                ['group_key' => $group['group_key']],
                $group
            );
        }
    }
}
