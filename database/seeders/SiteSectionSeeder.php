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
                'key' => 'about_intro',
                'title' => 'About Best Choice Travel',
                'subtitle' => 'Your Trusted Travel Partner in Egypt',
                'description' => "Best Choice Travel (BCT) is a professional tour operator and destination management company (DMC) based in Egypt, dedicated to delivering exceptional travel experiences to clients from around the world. Established in 2007, the company has built a strong reputation for providing high-quality travel services, personalized itineraries, and unforgettable journeys across Egypt and the Middle East.",
                'content' => "From the ancient wonders of the Pyramids and the temples of Luxor to the stunning beaches of the Red Sea, Best Choice Travel creates carefully designed travel experiences that combine history, culture, adventure, and luxury.",
                'button_text' => null,
                'button_link' => null,
                'image_path' => null,
                'sort_order' => 11,
            ],
            [
                'key' => 'about_credentials',
                'title' => 'Licensed Travel Company - Category (A)',
                'subtitle' => 'Official Credentials',
                'description' => 'Best Choice Travel is a fully licensed Egyptian travel agency, classified as Category (A) by the Egyptian Ministry of Tourism, the highest level of licensing for tourism companies in Egypt.',
                'content' => json_encode([
                    ['label' => 'Tourism License', 'value' => 'Category (A) - License No. 1575'],
                    ['label' => 'Member of', 'value' => 'Egyptian Travel Agents Association (ETAA)'],
                    ['label' => 'IATA Membership', 'value' => 'No. 90228121'],
                    ['label' => 'Established', 'value' => '2007'],
                ]),
                'button_text' => null,
                'button_link' => null,
                'image_path' => null,
                'sort_order' => 12,
            ],
            [
                'key' => 'about_mission',
                'title' => 'Our Mission',
                'subtitle' => null,
                'description' => 'Our mission is to provide travelers with authentic, memorable, and seamless travel experiences in Egypt while maintaining the highest standards of professionalism, safety, and customer satisfaction.',
                'content' => null,
                'button_text' => null,
                'button_link' => null,
                'image_path' => null,
                'sort_order' => 13,
            ],
            [
                'key' => 'about_vision',
                'title' => 'Our Vision',
                'subtitle' => null,
                'description' => 'Our vision is to become one of the leading travel companies in the MENA region by delivering innovative tourism services and unforgettable travel experiences that showcase the beauty, heritage, and hospitality of Egypt.',
                'content' => null,
                'button_text' => null,
                'button_link' => null,
                'image_path' => null,
                'sort_order' => 14,
            ],
            [
                'key' => 'about_services',
                'title' => 'What We Offer',
                'subtitle' => 'Travel Solutions',
                'description' => 'Best Choice Travel provides a full range of tourism services:',
                'content' => json_encode([
                    ['icon' => 'fa-map-location-dot', 'title' => 'Egypt Tour Packages', 'text' => 'Tailor-made itineraries including Cairo, Luxor, Aswan, Alexandria, and the Red Sea destinations.'],
                    ['icon' => 'fa-ship', 'title' => 'Nile Cruise Experiences', 'text' => 'Luxury Nile cruises and Dahabiya sailing journeys between Luxor and Aswan.'],
                    ['icon' => 'fa-camera-retro', 'title' => 'Day Tours & Excursions', 'text' => 'Private guided tours across Egypt’s most famous destinations.'],
                    ['icon' => 'fa-gem', 'title' => 'Luxury & Tailor-Made Travel', 'text' => 'Customized itineraries designed for discerning travelers seeking premium experiences.'],
                    ['icon' => 'fa-briefcase', 'title' => 'Corporate Travel & MICE', 'text' => 'Professional organization of meetings, incentives, conferences, and events.'],
                    ['icon' => 'fa-van-shuttle', 'title' => 'Transportation Services', 'text' => 'Private airport transfers, limousine services, and modern transportation solutions.'],
                ]),
                'button_text' => null,
                'button_link' => null,
                'image_path' => null,
                'sort_order' => 15,
            ],
            [
                'key' => 'about_why_choose',
                'title' => 'Why Choose Best Choice Travel',
                'subtitle' => null,
                'description' => null,
                'content' => json_encode([
                    ['icon' => 'fa-shield-halved', 'title' => 'Licensed & Trusted', 'text' => 'Operating under an official tourism license Category (A), ensuring full compliance with Egyptian tourism regulations.'],
                    ['icon' => 'fa-user-tie', 'title' => 'Experienced Team', 'text' => 'Professional travel advisors, certified Egyptologist guides, and dedicated support staff.'],
                    ['icon' => 'fa-wand-magic-sparkles', 'title' => 'Tailor-Made Experiences', 'text' => 'Every itinerary is customized according to traveler preferences.'],
                    ['icon' => 'fa-scale-balanced', 'title' => 'Quality & Value', 'text' => 'Competitive prices combined with premium travel services.'],
                    ['icon' => 'fa-headset', 'title' => '24/7 Customer Support', 'text' => 'Dedicated assistance before, during, and after your trip.'],
                ]),
                'button_text' => null,
                'button_link' => null,
                'image_path' => null,
                'sort_order' => 16,
            ],
            [
                'key' => 'about_cta',
                'title' => 'Discover Egypt with Confidence',
                'subtitle' => null,
                'description' => 'Whether you are looking for a cultural journey through the ancient temples, a relaxing holiday on the Red Sea, or a luxury Nile cruise adventure, Best Choice Travel is committed to making your dream trip to Egypt a reality.',
                'content' => null,
                'button_text' => null,
                'button_link' => null,
                'image_path' => null,
                'sort_order' => 17,
            ],
        ];

        foreach ($sections as $data) {
            // Ensure missing columns in older records get filled too
            $defaults = array_merge(['content' => null], $data);
            SiteSection::updateOrCreate(['key' => $data['key']], $defaults);
        }

        // Site Sections admin is only for Home + About; remove legacy Contact page blocks if any.
        SiteSection::query()->where('key', 'like', 'contact_%')->delete();
    }
}

