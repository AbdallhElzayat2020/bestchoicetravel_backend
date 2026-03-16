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
            [
                'key' => 'about_banner',
                'title' => 'About Us',
                'subtitle' => 'Discover who we are and why travelers choose us',
                'description' => null,
                'content' => null,
                'button_text' => null,
                'button_link' => null,
                'image_path' => null,
                'sort_order' => 10,
            ],
            [
                'key' => 'about_hero',
                'title' => 'A Boutique Egypt Specialist Tour Operator',
                'subtitle' => 'ABOUT TRAVEL EGYPT TOURS',
                'description' => "We are a dedicated Egyptian travel company crafting premium, small‑group and private journeys across Cairo, Luxor, Aswan, the Nile, Red Sea and beyond — built for travellers who want comfort, authenticity and zero stress.",
                'content' => null,
                'button_text' => null,
                'button_link' => null,
                'image_path' => 'assets/frontend/images/hero-bg.png',
                'sort_order' => 11,
            ],
            [
                'key' => 'about_story',
                'title' => 'Our Story as a Local Tour Operator',
                'subtitle' => null,
                'description' => "Travel Egypt Tours was founded by a team of Egyptians who grew up between the temples of Luxor, the narrow streets of Old Cairo and the golden dunes of the Sahara. We started as on‑the‑ground guides, then grew into a boutique tour operator that designs journeys we would proudly host our own families on.\n\nToday, our travel designers, licensed Egyptologists and operations team work together to combine iconic highlights with hidden gems, boutique stays and curated experiences — from Nile cruises and desert safaris to Red Sea escapes.",
                'content' => null,
                'button_text' => null,
                'button_link' => null,
                'image_path' => null,
                'sort_order' => 12,
            ],
            [
                'key' => 'about_why',
                'title' => 'Why Travel With Us?',
                'subtitle' => null,
                'description' => null,
                'content' => json_encode([
                    [
                        'icon' => 'fa-solid fa-globe',
                        'title' => 'Global Reach',
                        'text' => 'Serving travelers from USA, UK, Australia & worldwide with seamless booking and support.',
                        'color' => 'blue',
                    ],
                    [
                        'icon' => 'fa-solid fa-user-check',
                        'title' => 'Expert Guides',
                        'text' => 'Professional Egyptologist guides for every journey — history, culture, and hidden gems.',
                        'color' => 'gold',
                    ],
                    [
                        'icon' => 'fa-solid fa-clock',
                        'title' => '24/7 Support',
                        'text' => 'Local support ensuring a seamless travel experience from arrival to departure.',
                        'color' => 'green',
                    ],
                    [
                        'icon' => 'fa-solid fa-location-dot',
                        'title' => 'Handpicked',
                        'text' => 'Carefully selected hotels and luxury Nile cruises for comfort and authenticity.',
                        'color' => 'blue',
                    ],
                ]),
                'button_text' => null,
                'button_link' => null,
                'image_path' => null,
                'sort_order' => 13,
            ],
        ];

        foreach ($sections as $data) {
            // Ensure missing columns in older records get filled too
            $defaults = array_merge(['content' => null], $data);
            SiteSection::updateOrCreate(['key' => $data['key']], $defaults);
        }
    }
}

