<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Country;
use App\Models\State;
use App\Models\SubCategory;
use App\Models\Tour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $egypt = Country::where('code', 'EGY')->first();
        $cairo = State::where('slug', 'cairo')->first();
        $giza = State::where('slug', 'giza')->first();
        $luxor = State::where('slug', 'luxor')->first();
        $aswan = State::where('slug', 'aswan')->first();
        $hurghada = State::where('slug', 'hurghada')->first();
        $sharmElSheikh = State::where('slug', 'sharm-el-sheikh')->first();

        $saudi = Country::where('code', 'SAU')->first();
        $riyadh = State::where('slug', 'riyadh')->first();
        $mecca = State::where('slug', 'mecca')->first();

        $uae = Country::where('code', 'ARE')->first();
        $dubai = State::where('slug', 'dubai')->first();

        // Make sure required countries/states exist
        if (!$egypt || !$cairo || !$giza || !$luxor || !$aswan || !$hurghada || !$sharmElSheikh || !$saudi || !$riyadh || !$mecca || !$uae || !$dubai) {
            $this->command->warn('Required countries or states not found. Please run CountrySeeder and StateSeeder first.');
            return;
        }

        // Ensure required categories exist (create if missing)
        $nileCruisesCategory = Category::firstOrCreate(
            ['slug' => 'nile-cruises'],
            ['name' => 'Nile Cruises', 'status' => 'active', 'sort_order' => 1]
        );

        $dahbiaToursCategory = Category::firstOrCreate(
            ['slug' => 'dahbia-tours'],
            ['name' => 'Dahabiya Tours', 'status' => 'active', 'sort_order' => 2]
        );

        $tourEgyptPackagesCategory = Category::firstOrCreate(
            ['slug' => 'tour-egypt-packages'],
            ['name' => 'Tour Egypt Packages', 'status' => 'active', 'sort_order' => 3]
        );

        // Tours data
        $tours = [
            [
                'category_id' => $nileCruisesCategory->id,
                'country_id' => $egypt->id,
                'state_id' => $cairo->id,
                'title' => 'Cairo and Giza Pyramids Tour',
                'slug' => 'cairo-and-giza-pyramids-tour',
                'short_description' => 'Explore the ancient wonders of Egypt including the Great Pyramids of Giza, Sphinx, and the Egyptian Museum.',
                'description' => '<p>Discover the magic of ancient Egypt with our comprehensive Cairo and Giza Pyramids tour. Visit the iconic Great Pyramid of Giza, one of the Seven Wonders of the Ancient World, and marvel at the enigmatic Sphinx. Explore the treasures of the Egyptian Museum, home to thousands of artifacts including the golden mask of Tutankhamun.</p><p>Experience the vibrant culture of Cairo, stroll through the historic Khan El Khalili bazaar, and enjoy traditional Egyptian cuisine. This tour offers a perfect blend of history, culture, and adventure.</p>',
                'meta_title' => 'Cairo and Giza Pyramids Tour - Explore Ancient Egypt',
                'meta_description' => 'Join our Cairo and Giza Pyramids tour to discover the wonders of ancient Egypt. Visit the Great Pyramids, Sphinx, and Egyptian Museum.',
                'meta_keywords' => 'Cairo tour, Giza Pyramids, Egypt travel, ancient Egypt, Sphinx, Egyptian Museum',
                'duration' => 3,
                'duration_type' => 'days',
                'status' => 'active',
                'show_on_homepage' => true,
                'price' => 450.00,
                'has_offer' => true,
                'price_before_discount' => 550.00,
                'price_after_discount' => 450.00,
                'offer_start_date' => now()->format('Y-m-d'),
                'offer_end_date' => now()->addMonths(3)->format('Y-m-d'),
                'notes' => 'Includes accommodation, breakfast, and guided tours. Airport transfers available.',
                'sort_order' => 1,
            ],
            [
                'category_id' => $nileCruisesCategory->id,
                'country_id' => $egypt->id,
                'state_id' => $luxor->id,
                'title' => 'Luxor and Aswan Nile Cruise',
                'slug' => 'luxor-and-aswan-nile-cruise',
                'short_description' => 'Sail along the Nile River and explore the magnificent temples of Luxor and Aswan, including Valley of the Kings.',
                'description' => '<p>Embark on an unforgettable journey along the legendary Nile River. Visit the Valley of the Kings, where pharaohs were buried in elaborate tombs. Explore the magnificent temples of Karnak and Luxor, marvel at the Colossi of Memnon, and discover the beautiful Philae Temple in Aswan.</p><p>Enjoy luxurious accommodation on a traditional Nile cruise ship, savor delicious Egyptian and international cuisine, and witness breathtaking sunsets over the Nile. This is the perfect way to experience the rich history and natural beauty of Upper Egypt.</p>',
                'meta_title' => 'Luxor and Aswan Nile Cruise - Ancient Egyptian Temples',
                'meta_description' => 'Experience the magic of the Nile with our Luxor and Aswan cruise. Visit Valley of the Kings, Karnak Temple, and more.',
                'meta_keywords' => 'Nile cruise, Luxor tour, Aswan tour, Valley of the Kings, Karnak Temple, Egypt cruise',
                'duration' => 5,
                'duration_type' => 'days',
                'status' => 'active',
                'show_on_homepage' => true,
                'price' => 850.00,
                'has_offer' => false,
                'notes' => 'All meals included. Optional hot air balloon ride over Luxor available.',
                'sort_order' => 2,
            ],
            [
                'category_id' => $dahbiaToursCategory->id,
                'country_id' => $egypt->id,
                'state_id' => $hurghada->id,
                'title' => 'Hurghada Red Sea Paradise',
                'slug' => 'hurghada-red-sea-paradise',
                'short_description' => 'Relax on pristine beaches, dive into crystal-clear waters, and enjoy world-class water sports in Hurghada.',
                'description' => '<p>Escape to the Red Sea paradise of Hurghada, where golden beaches meet turquoise waters. This resort destination offers the perfect blend of relaxation and adventure.</p><p>Snorkel or dive among vibrant coral reefs teeming with marine life, try exciting water sports like windsurfing and parasailing, or simply unwind on the beach. Enjoy luxurious resort accommodations with stunning sea views, indulge in spa treatments, and savor fresh seafood at beachfront restaurants.</p>',
                'meta_title' => 'Hurghada Red Sea Resort - Beach Paradise Egypt',
                'meta_description' => 'Discover Hurghada\'s beautiful beaches and world-class diving. Perfect for relaxation and water sports enthusiasts.',
                'meta_keywords' => 'Hurghada, Red Sea, beach resort, diving Egypt, snorkeling, water sports',
                'duration' => 7,
                'duration_type' => 'days',
                'status' => 'active',
                'show_on_homepage' => true,
                'price' => 650.00,
                'has_offer' => true,
                'price_before_discount' => 750.00,
                'price_after_discount' => 650.00,
                'offer_start_date' => now()->format('Y-m-d'),
                'offer_end_date' => now()->addMonths(2)->format('Y-m-d'),
                'notes' => 'All-inclusive resort package. Diving equipment rental available.',
                'sort_order' => 3,
            ],
            [
                'category_id' => $dahbiaToursCategory->id,
                'country_id' => $egypt->id,
                'state_id' => $sharmElSheikh->id,
                'title' => 'Sharm El Sheikh Adventure & Diving',
                'slug' => 'sharm-el-sheikh-adventure-diving',
                'short_description' => 'Experience world-renowned diving sites, desert adventures, and vibrant nightlife in Sharm El Sheikh.',
                'description' => '<p>Sharm El Sheikh is a diver\'s paradise, home to some of the world\'s most spectacular dive sites including Ras Mohammed National Park. Explore colorful coral reefs, encounter diverse marine life including sharks and dolphins, and enjoy crystal-clear visibility.</p><p>Beyond diving, experience thrilling desert safaris, quad biking adventures, and camel rides. In the evening, enjoy vibrant nightlife, shopping at Naama Bay, and dining at world-class restaurants. This destination offers the perfect combination of adventure and relaxation.</p>',
                'meta_title' => 'Sharm El Sheikh Diving & Adventure Tours',
                'meta_description' => 'Dive into Sharm El Sheikh\'s world-class diving sites and enjoy desert adventures. Perfect for adventure seekers.',
                'meta_keywords' => 'Sharm El Sheikh, diving, Ras Mohammed, desert safari, adventure Egypt',
                'duration' => 6,
                'duration_type' => 'days',
                'status' => 'active',
                'show_on_homepage' => false,
                'price' => 750.00,
                'has_offer' => false,
                'notes' => 'PADI certification courses available. Desert safari and quad biking included.',
                'sort_order' => 4,
            ],
            [
                'category_id' => $tourEgyptPackagesCategory->id,
                'country_id' => $saudi->id,
                'state_id' => $mecca->id,
                'title' => 'Umrah Package - Mecca and Medina',
                'slug' => 'umrah-package-mecca-medina',
                'short_description' => 'Perform Umrah with ease and comfort. Visit the holy cities of Mecca and Medina with our comprehensive package.',
                'description' => '<p>Embark on a spiritual journey to the holiest cities in Islam. Our Umrah package includes all necessary arrangements for a comfortable and meaningful pilgrimage.</p><p>Visit the Grand Mosque in Mecca, perform Tawaf around the Kaaba, and walk between Safa and Marwa. Travel to Medina to visit the Prophet\'s Mosque and pay respects at historical Islamic sites. Our package includes accommodation near the holy mosques, transportation, and guidance throughout your journey.</p>',
                'meta_title' => 'Umrah Package - Mecca and Medina Pilgrimage',
                'meta_description' => 'Complete Umrah package to Mecca and Medina. Comfortable accommodation and transportation included.',
                'meta_keywords' => 'Umrah, Mecca, Medina, pilgrimage, Hajj, Islamic travel',
                'duration' => 10,
                'duration_type' => 'days',
                'status' => 'active',
                'show_on_homepage' => true,
                'price' => 1200.00,
                'has_offer' => false,
                'notes' => 'Visa assistance provided. All meals included. Group and individual packages available.',
                'sort_order' => 5,
            ],
            [
                'category_id' => $tourEgyptPackagesCategory->id,
                'country_id' => $uae->id,
                'state_id' => $dubai->id,
                'title' => 'Dubai City Tour & Desert Safari',
                'slug' => 'dubai-city-tour-desert-safari',
                'short_description' => 'Explore modern Dubai, visit iconic landmarks, and experience thrilling desert adventures.',
                'description' => '<p>Discover the modern marvels of Dubai, from the world\'s tallest building Burj Khalifa to the luxurious Palm Jumeirah. Visit the Dubai Mall, enjoy shopping at traditional souks, and experience the vibrant culture of this cosmopolitan city.</p><p>Experience an exhilarating desert safari with dune bashing, camel rides, and traditional Bedouin camp entertainment. Enjoy a delicious BBQ dinner under the stars while watching belly dancing and Tanoura shows. This tour perfectly combines urban exploration with desert adventure.</p>',
                'meta_title' => 'Dubai City Tour & Desert Safari - Modern Luxury',
                'meta_description' => 'Explore Dubai\'s iconic landmarks and enjoy thrilling desert safari adventures. Perfect city and desert experience.',
                'meta_keywords' => 'Dubai tour, Burj Khalifa, desert safari, Dubai Mall, UAE travel',
                'duration' => 4,
                'duration_type' => 'days',
                'status' => 'active',
                'show_on_homepage' => true,
                'price' => 550.00,
                'has_offer' => true,
                'price_before_discount' => 650.00,
                'price_after_discount' => 550.00,
                'offer_start_date' => now()->format('Y-m-d'),
                'offer_end_date' => now()->addMonths(4)->format('Y-m-d'),
                'notes' => 'Burj Khalifa tickets included. Desert safari with BBQ dinner. Hotel accommodation in city center.',
                'sort_order' => 6,
            ],
        ];

        // Ensure upload directory exists
        $uploadDir = public_path('uploads/tours');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $sourceDir = public_path('assets/frontend/assets/images');
        $tourImages = ['destination-01.png', 'destination-02.png', 'destination-03.png', 'destination-04.png', 'destination-05.png', 'destination-06.png'];

        foreach ($tours as $index => $tourData) {
            $tour = Tour::firstOrCreate(
                ['slug' => $tourData['slug']],
                $tourData
            );

            // Add cover image if it doesn't exist
            if (!$tour->cover_image && isset($tourImages[$index % count($tourImages)])) {
                $imageName = $tourImages[$index % count($tourImages)];
                $sourcePath = $sourceDir . '/' . $imageName;
                if (file_exists($sourcePath)) {
                    $destinationPath = $uploadDir . '/' . $imageName;
                    copy($sourcePath, $destinationPath);
                    $tour->update(['cover_image' => $imageName]);
                }
            }
        }

        $this->command->info('Tours seeded successfully!');
    }
}
