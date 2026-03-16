<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name' => 'Egypt',
                'code' => 'EGY',
                'slug' => 'egypt',
                'status' => 'active',
                'sort_order' => 1,
            ],
            [
                'name' => 'Saudi Arabia',
                'code' => 'SAU',
                'slug' => 'saudi-arabia',
                'status' => 'active',
                'sort_order' => 2,
            ],
            [
                'name' => 'United Arab Emirates',
                'code' => 'ARE',
                'slug' => 'united-arab-emirates',
                'status' => 'active',
                'sort_order' => 3,
            ],
            [
                'name' => 'Jordan',
                'code' => 'JOR',
                'slug' => 'jordan',
                'status' => 'active',
                'sort_order' => 4,
            ],
            [
                'name' => 'Turkey',
                'code' => 'TUR',
                'slug' => 'turkey',
                'status' => 'active',
                'sort_order' => 5,
            ],
            [
                'name' => 'Morocco',
                'code' => 'MAR',
                'slug' => 'morocco',
                'status' => 'active',
                'sort_order' => 6,
            ],
            [
                'name' => 'Tunisia',
                'code' => 'TUN',
                'slug' => 'tunisia',
                'status' => 'active',
                'sort_order' => 7,
            ],
            [
                'name' => 'Lebanon',
                'code' => 'LBN',
                'slug' => 'lebanon',
                'status' => 'active',
                'sort_order' => 8,
            ],
            [
                'name' => 'Oman',
                'code' => 'OMN',
                'slug' => 'oman',
                'status' => 'active',
                'sort_order' => 9,
            ],
            [
                'name' => 'Qatar',
                'code' => 'QAT',
                'slug' => 'qatar',
                'status' => 'active',
                'sort_order' => 10,
            ],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['slug' => $country['slug']],
                $country
            );
        }
    }
}
