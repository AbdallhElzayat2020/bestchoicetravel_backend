<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Permissions first, then Roles and Admin User
        $this->call([
            PermissionSeeder::class,
            AdminSeeder::class,
            CategorySeeder::class,
            ContactSeeder::class,
            SubscriberSeeder::class,
            SliderSeeder::class,
            TestimonialSeeder::class,
            FaqSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            TourSeeder::class,
            TourDaySeeder::class,
            TourVariantSeeder::class,
            BlogCategorySeeder::class,
            BlogSeeder::class,
            GallerySeeder::class,
            PageSeeder::class,
            CruiseGroupSeeder::class, // Must be before CruiseExperienceSeeder
            CruiseExperienceSeeder::class,
            SiteSectionSeeder::class,
            AnnouncementSeeder::class,
        ]);
    }
}
