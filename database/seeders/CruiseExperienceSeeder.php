<?php

namespace Database\Seeders;

use App\Models\CruiseExperience;
use App\Models\CruiseExperienceImage;
use App\Models\CruiseGroup;
use App\Models\Tour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CruiseExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch groups by key so we can attach specific experiences
        $egyptToursGroup = CruiseGroup::where('group_key', 'egypt-tours')->first();
        $nileCruisesGroup = CruiseGroup::where('group_key', 'nile-cruises')->first();
        $dayExcursionsGroup = CruiseGroup::where('group_key', 'day-excursions')->first();
        $egyptBeyondGroup = CruiseGroup::where('group_key', 'egypt-and-beyond')->first();

        $experiences = [];

        if ($egyptToursGroup) {
            $experiences[] = [
                'title' => 'Egypt Tour Packages',
                'slug' => 'egypt-tour-packages',
                'short_description' => 'Explore our best Egypt tour packages covering Cairo, Luxor, Aswan, and more.',
                'description' => '<p>Discover Egypt through carefully crafted tour packages that combine history, culture, and relaxation.</p>',
                'meta_title' => 'Egypt Tour Packages',
                'meta_description' => 'Browse our Egypt tour packages including Cairo, Luxor, Aswan, and Red Sea extensions.',
                'meta_keywords' => 'Egypt tours, tour packages, Cairo, Luxor, Aswan',
                'status' => 'active',
                'sort_order' => 1,
                'group_key' => $egyptToursGroup->group_key,
                'cruise_group_id' => $egyptToursGroup->id,
                'images' => ['destination-01.png', 'destination-02.png'],
            ];

            $experiences[] = [
                'title' => 'Egypt Desert Tours',
                'slug' => 'egypt-desert-tours',
                'short_description' => 'Adventure across Egypt’s golden deserts and oases.',
                'description' => '<p>Join unforgettable desert adventures across the White Desert, Siwa Oasis, and more.</p>',
                'meta_title' => 'Egypt Desert Tours',
                'meta_description' => 'Discover Egypt desert tours including safaris, camping, and oasis experiences.',
                'meta_keywords' => 'Egypt desert tours, White Desert, Siwa Oasis, safari',
                'status' => 'active',
                'sort_order' => 2,
                'group_key' => $egyptToursGroup->group_key,
                'cruise_group_id' => $egyptToursGroup->id,
                'images' => ['destination-03.png', 'destination-04.png'],
            ];

            $experiences[] = [
                'title' => 'Red Sea Vacations',
                'slug' => 'red-sea-vacations',
                'short_description' => 'Relax by the Red Sea with crystal-clear waters and vibrant coral reefs.',
                'description' => '<p>Enjoy beachfront resorts, snorkeling, and diving in Hurghada and Sharm El Sheikh.</p>',
                'meta_title' => 'Red Sea Vacations',
                'meta_description' => 'Plan your Red Sea vacation with beach resorts, snorkeling, and diving.',
                'meta_keywords' => 'Red Sea, Hurghada, Sharm El Sheikh, beach holidays',
                'status' => 'active',
                'sort_order' => 3,
                'group_key' => $egyptToursGroup->group_key,
                'cruise_group_id' => $egyptToursGroup->id,
                'images' => ['destination-05.png', 'destination-06.png'],
            ];
        }

        if ($nileCruisesGroup) {
            $experiences[] = [
                'title' => 'Nile Cruises',
                'slug' => 'nile-cruises-experiences',
                'short_description' => 'Classic Nile cruises between Luxor and Aswan with guided temple visits.',
                'description' => '<p>Sail the Nile on modern cruise ships with comfortable cabins and daily excursions.</p>',
                'meta_title' => 'Nile Cruises',
                'meta_description' => 'Discover our Nile cruise options between Luxor and Aswan.',
                'meta_keywords' => 'Nile cruises, Luxor, Aswan, Egypt river cruise',
                'status' => 'active',
                'sort_order' => 1,
                'group_key' => $nileCruisesGroup->group_key,
                'cruise_group_id' => $nileCruisesGroup->id,
                'images' => ['destination-01.png', 'destination-02.png'],
            ];

            $experiences[] = [
                'title' => 'Dahabiya Nile Cruises',
                'slug' => 'dahabiya-nile-cruises',
                'short_description' => 'Sail the Nile on intimate, traditional Dahabiya sailing boats.',
                'description' => '<p>Enjoy a relaxed Nile experience with smaller boats, fewer guests, and personalized service.</p>',
                'meta_title' => 'Dahabiya Nile Cruises',
                'meta_description' => 'Experience authentic Dahabiya Nile cruises with luxury comfort.',
                'meta_keywords' => 'Dahabiya, Nile cruises, Egypt sailing boat',
                'status' => 'active',
                'sort_order' => 2,
                'group_key' => $nileCruisesGroup->group_key,
                'cruise_group_id' => $nileCruisesGroup->id,
                'images' => ['destination-03.png', 'destination-04.png'],
            ];
        }

        if ($dayExcursionsGroup) {
            $experiences[] = [
                'title' => 'Day Excursions',
                'slug' => 'day-excursions-egypt',
                'short_description' => 'Full-day and half-day excursions from major Egyptian cities.',
                'description' => '<p>Perfect short trips from Cairo, Luxor, Aswan, and the Red Sea resorts.</p>',
                'meta_title' => 'Egypt Day Excursions',
                'meta_description' => 'Book Egypt day excursions to pyramids, museums, and local attractions.',
                'meta_keywords' => 'day trips, excursions, Cairo tours',
                'status' => 'active',
                'sort_order' => 1,
                'group_key' => $dayExcursionsGroup->group_key,
                'cruise_group_id' => $dayExcursionsGroup->id,
                'images' => ['destination-05.png'],
            ];
        }

        if ($egyptBeyondGroup) {
            $experiences[] = [
                'title' => 'Egypt & Jordan Tours',
                'slug' => 'egypt-and-jordan-tours',
                'short_description' => 'Combine Egypt highlights with Petra and Wadi Rum in Jordan.',
                'description' => '<p>Multi-country tours covering Egypt and Jordan in one unforgettable journey.</p>',
                'meta_title' => 'Egypt & Jordan Tours',
                'meta_description' => 'Explore Egypt and Jordan in combined tour packages.',
                'meta_keywords' => 'Egypt and Jordan tours, Petra, Wadi Rum',
                'status' => 'active',
                'sort_order' => 1,
                'group_key' => $egyptBeyondGroup->group_key,
                'cruise_group_id' => $egyptBeyondGroup->id,
                'images' => ['destination-06.png', 'destination-07.png'],
            ];
        }

        // Ensure upload directory exists
        $uploadDir = public_path('uploads/cruise-experiences');
        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        foreach ($experiences as $experienceData) {
            $images = $experienceData['images'] ?? [];
            unset($experienceData['images']);

            $experience = CruiseExperience::firstOrCreate(
                ['slug' => $experienceData['slug']],
                $experienceData
            );

            // Add images if they don't exist
            if ($experience->images()->count() == 0 && !empty($images)) {
                foreach ($images as $index => $imageName) {
                    $sourcePath = public_path('assets/frontend/assets/images/' . $imageName);
                    if (file_exists($sourcePath)) {
                        $destinationPath = $uploadDir . '/' . $imageName;
                        copy($sourcePath, $destinationPath);

                        CruiseExperienceImage::create([
                            'cruise_experience_id' => $experience->id,
                            'image' => $imageName,
                            'sort_order' => $index + 1,
                        ]);
                    }
                }
            }

            // Attach some tours if available
            if ($experience->tours()->count() == 0) {
                $tours = Tour::active()->limit(3)->get();
                if ($tours->count() > 0) {
                    $experience->tours()->attach($tours->pluck('id')->toArray());
                }
            }
        }

        $this->command->info('Cruise Experiences seeded successfully!');
    }
}
