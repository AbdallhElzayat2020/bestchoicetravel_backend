<?php

namespace Database\Seeders;

use App\Models\SiteSection;
use Illuminate\Database\Seeder;

class SiteSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'key' => 'home_hero',
                'title' => "Discover Egypt's Magic",
                'subtitle' => 'Luxury, tailor-made journeys to explore the wonders of ancient and modern Egypt.',
                'description' => null,
                'button_text' => 'Egypt Tours',
                'button_link' => '#packages',
                'image_path' => 'assets/frontend/images/hero-bg.png',
                'sort_order' => 1,
            ],
            [
                'key' => 'home_cruises',
                'title' => 'Royal Nile River Cruises',
                'subtitle' => 'Luxury Experience',
                'description' => 'Enjoy a magical journey aboard the most luxurious Nile ships, where ultimate comfort meets the magic of Pharaonic history.',
                'button_text' => 'Book Your Nile Cruise',
                'button_link' => '#packages',
                'image_path' => 'assets/frontend/images/Aswan.webp',
                'sort_order' => 2,
            ],
            [
                'key' => 'home_day_tours',
                'title' => 'Discover Egypt Day Tours',
                'subtitle' => 'Guided City & Museum Tours',
                'description' => 'Explore the best Egypt Day Tours to the Pyramids, Luxor temples, and Aswan with a Nubian experience. Enjoy guided trips, rich history, and unforgettable experiences in one day.',
                'button_text' => 'Egypt Day Tours',
                'button_link' => '#packages',
                'image_path' => null,
                'sort_order' => 3,
            ],
            [
                'key' => 'home_desert',
                'title' => 'Egyptian Desert Safari',
                'subtitle' => 'An Unforgettable Adventure',
                'description' => "Ride across Egypt's golden dunes at sunset, camp under a sky filled with stars, and feel the silence of the desert with our expert Bedouin guides and premium desert camps.",
                'button_text' => 'Book Your Adventure',
                'button_link' => '#packages',
                'image_path' => 'assets/frontend/images/desert-safar.jpg',
                'sort_order' => 4,
            ],
            [
                'key' => 'home_egypt_jordan',
                'title' => 'Egypt & Jordan Tours',
                'subtitle' => 'An Unforgettable Adventure',
                'description' => "Ride across Egypt's golden dunes at sunset, camp under a sky filled with stars, and feel the silence of the desert with our expert Bedouin guides and premium desert camps.",
                'button_text' => 'Book Your Adventure',
                'button_link' => '#packages',
                'image_path' => 'assets/frontend/images/jordan.jpeg',
                'sort_order' => 5,
            ],
            [
                'key' => 'home_redsea',
                'title' => 'Red Sea Holidays',
                'subtitle' => 'Red Sea Vacations',
                'description' => "Dive into a magical world of colorful coral reefs and incredible marine life. Enjoy unforgettable diving experiences in crystal-clear waters along Egypt's Red Sea coast.",
                'button_text' => 'Red Sea Holidays',
                'button_link' => '#packages',
                'image_path' => null,
                'sort_order' => 6,
            ],
        ];

        foreach ($sections as $data) {
            SiteSection::updateOrCreate(
                ['key' => $data['key']],
                $data
            );
        }
    }
}

