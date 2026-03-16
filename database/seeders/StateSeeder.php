<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $egypt = Country::where('code', 'EGY')->first();

        if ($egypt) {
            $egyptStates = [
                ['name' => 'Cairo', 'slug' => 'cairo', 'status' => 'active', 'sort_order' => 1],
                ['name' => 'Giza', 'slug' => 'giza', 'status' => 'active', 'sort_order' => 2],
                ['name' => 'Alexandria', 'slug' => 'alexandria', 'status' => 'active', 'sort_order' => 3],
                ['name' => 'Luxor', 'slug' => 'luxor', 'status' => 'active', 'sort_order' => 4],
                ['name' => 'Aswan', 'slug' => 'aswan', 'status' => 'active', 'sort_order' => 5],
                ['name' => 'Hurghada', 'slug' => 'hurghada', 'status' => 'active', 'sort_order' => 6],
                ['name' => 'Sharm El Sheikh', 'slug' => 'sharm-el-sheikh', 'status' => 'active', 'sort_order' => 7],
                ['name' => 'Sinai', 'slug' => 'sinai', 'status' => 'active', 'sort_order' => 8],
                ['name' => 'Red Sea', 'slug' => 'red-sea', 'status' => 'active', 'sort_order' => 9],
            ];

            foreach ($egyptStates as $state) {
                State::updateOrCreate(
                    ['slug' => $state['slug']],
                    [
                        'country_id' => $egypt->id,
                        'name' => $state['name'],
                        'slug' => $state['slug'],
                        'status' => $state['status'],
                        'sort_order' => $state['sort_order'],
                    ]
                );
            }
        }

        $saudi = Country::where('code', 'SAU')->first();

        if ($saudi) {
            $saudiStates = [
                ['name' => 'Riyadh', 'slug' => 'riyadh', 'status' => 'active', 'sort_order' => 1],
                ['name' => 'Jeddah', 'slug' => 'jeddah', 'status' => 'active', 'sort_order' => 2],
                ['name' => 'Mecca', 'slug' => 'mecca', 'status' => 'active', 'sort_order' => 3],
                ['name' => 'Medina', 'slug' => 'medina', 'status' => 'active', 'sort_order' => 4],
                ['name' => 'Dammam', 'slug' => 'dammam', 'status' => 'active', 'sort_order' => 5],
            ];

            foreach ($saudiStates as $state) {
                State::updateOrCreate(
                    ['slug' => $state['slug']],
                    [
                        'country_id' => $saudi->id,
                        'name' => $state['name'],
                        'slug' => $state['slug'],
                        'status' => $state['status'],
                        'sort_order' => $state['sort_order'],
                    ]
                );
            }
        }

        $uae = Country::where('code', 'ARE')->first();

        if ($uae) {
            $uaeStates = [
                ['name' => 'Dubai', 'slug' => 'dubai', 'status' => 'active', 'sort_order' => 1],
                ['name' => 'Abu Dhabi', 'slug' => 'abu-dhabi', 'status' => 'active', 'sort_order' => 2],
                ['name' => 'Sharjah', 'slug' => 'sharjah', 'status' => 'active', 'sort_order' => 3],
                ['name' => 'Ras Al Khaimah', 'slug' => 'ras-al-khaimah', 'status' => 'active', 'sort_order' => 4],
            ];

            foreach ($uaeStates as $state) {
                State::updateOrCreate(
                    ['slug' => $state['slug']],
                    [
                        'country_id' => $uae->id,
                        'name' => $state['name'],
                        'slug' => $state['slug'],
                        'status' => $state['status'],
                        'sort_order' => $state['sort_order'],
                    ]
                );
            }
        }
    }
}
