<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'Top 10 Must-Visit Destinations in Egypt',
                'slug' => 'top-10-must-visit-destinations-in-egypt',
                'short_description' => 'Discover the most breathtaking destinations in Egypt that every traveler should experience at least once in their lifetime.',
                'category' => 'Cairo & Pyramids',
                'description' => '<p>Egypt is a land of ancient wonders, stunning landscapes, and rich cultural heritage. From the iconic pyramids to the crystal-clear waters of the Red Sea, Egypt offers something for every type of traveler.</p><h3>1. The Great Pyramids of Giza</h3><p>No trip to Egypt is complete without visiting the Great Pyramids of Giza. These ancient structures have stood for over 4,500 years and continue to amaze visitors from around the world.</p><h3>2. Luxor and the Valley of the Kings</h3><p>Explore the ancient city of Luxor, home to some of the most impressive temples and tombs in Egypt. The Valley of the Kings is where pharaohs were buried with their treasures.</p><h3>3. The Red Sea Coast</h3><p>For beach lovers and diving enthusiasts, the Red Sea offers some of the world\'s best diving spots with vibrant coral reefs and diverse marine life.</p><h3>4. Abu Simbel Temples</h3><p>These massive rock temples were built by Ramesses II and are a testament to ancient Egyptian engineering and artistry.</p><h3>5. Cairo\'s Islamic Quarter</h3><p>Wander through the historic streets of Cairo\'s Islamic Quarter, where you\'ll find beautiful mosques, bustling markets, and traditional architecture.</p><p>Whether you\'re interested in history, adventure, or relaxation, Egypt has it all. Plan your trip today and experience the magic of this incredible country!</p>',
                'meta_title' => 'Top 10 Must-Visit Destinations in Egypt - Travel Guide',
                'meta_description' => 'Discover the best destinations in Egypt including pyramids, temples, beaches, and historic sites. Your complete travel guide to Egypt.',
                'meta_keywords' => 'Egypt travel, pyramids, Luxor, Red Sea, Abu Simbel, Cairo, Egypt destinations',
                'author' => 'Travel Expert',
                'status' => 'active',
                'show_on_homepage' => true,
                'published_at' => now()->subDays(5),
                'sort_order' => 1,
            ],
            [
                'title' => 'Best Time to Visit Egypt: A Complete Guide',
                'slug' => 'best-time-to-visit-egypt-complete-guide',
                'short_description' => 'Learn about the best seasons to visit Egypt, weather patterns, and tips for planning your perfect Egyptian adventure.',
                'category' => 'Travel Tips',
                'description' => '<p>Planning a trip to Egypt? Understanding the climate and best times to visit can make all the difference in your travel experience.</p><h3>Weather Overview</h3><p>Egypt has a desert climate with hot summers and mild winters. The country experiences very little rainfall throughout the year, making it an ideal destination for travelers seeking sunshine.</p><h3>Best Time to Visit: October to April</h3><p>The period from October to April is considered the best time to visit Egypt. During these months, temperatures are pleasant, ranging from 20°C to 30°C (68°F to 86°F), making it perfect for sightseeing and outdoor activities.</p><h3>Summer Months: May to September</h3><p>Summer in Egypt can be extremely hot, with temperatures often exceeding 40°C (104°F) in many areas. However, coastal regions like Sharm El Sheikh and Hurghada remain more comfortable, making them great summer destinations.</p><h3>Peak Tourist Season</h3><p>The peak tourist season runs from December to February, coinciding with winter holidays. During this time, popular sites can be crowded, so booking in advance is recommended.</p><h3>Shoulder Seasons</h3><p>March to May and September to November offer a great balance of good weather and fewer crowds. These are ideal times for travelers who want to avoid peak season while still enjoying pleasant conditions.</p><p>No matter when you visit, Egypt\'s timeless attractions will leave you in awe. Plan accordingly and enjoy your Egyptian adventure!</p>',
                'meta_title' => 'Best Time to Visit Egypt - Weather Guide & Travel Tips',
                'meta_description' => 'Discover the best time to visit Egypt based on weather, crowds, and activities. Complete guide to planning your Egyptian trip.',
                'meta_keywords' => 'Egypt weather, best time to visit Egypt, Egypt travel season, Egypt climate',
                'author' => 'Travel Expert',
                'status' => 'active',
                'show_on_homepage' => true,
                'published_at' => now()->subDays(3),
                'sort_order' => 2,
            ],
            [
                'title' => 'Egyptian Cuisine: A Food Lover\'s Guide',
                'slug' => 'egyptian-cuisine-food-lovers-guide',
                'short_description' => 'Explore the rich flavors of Egyptian cuisine, from traditional dishes to street food favorites that you must try during your visit.',
                'category' => 'Cairo & Pyramids',
                'description' => '<p>Egyptian cuisine is a delightful fusion of Middle Eastern, Mediterranean, and African flavors. From hearty main dishes to sweet desserts, Egyptian food is sure to tantalize your taste buds.</p><h3>Traditional Egyptian Dishes</h3><h4>Koshari</h4><p>Egypt\'s national dish, Koshari, is a hearty combination of rice, lentils, pasta, chickpeas, and crispy fried onions, all topped with a spicy tomato sauce. It\'s a must-try for any visitor.</p><h4>Ful Medames</h4><p>This traditional breakfast dish consists of fava beans cooked with garlic, lemon, and olive oil. It\'s typically served with bread and is a staple of Egyptian cuisine.</p><h4>Molokhia</h4><p>A green leafy vegetable cooked into a soup-like consistency, Molokhia is often served with rice and chicken or rabbit. It has a unique, slightly slimy texture that many Egyptians love.</p><h3>Street Food Favorites</h3><p>Egyptian street food is an experience in itself. Try ta\'ameya (Egyptian falafel), hawawshi (stuffed bread), or shawarma from local vendors for an authentic taste of Egypt.</p><h3>Desserts and Sweets</h3><p>Don\'t miss out on traditional Egyptian sweets like baklava, basbousa, and konafa. These honey-soaked pastries are perfect for satisfying your sweet tooth.</p><p>Exploring Egyptian cuisine is an adventure that will enhance your travel experience. Be sure to try these dishes during your visit!</p>',
                'meta_title' => 'Egyptian Cuisine Guide - Traditional Food & Street Food',
                'meta_description' => 'Discover the best of Egyptian cuisine including traditional dishes, street food, and desserts. Complete food guide for travelers.',
                'meta_keywords' => 'Egyptian food, Egyptian cuisine, Koshari, Egyptian street food, Egypt food guide',
                'author' => 'Food Traveler',
                'status' => 'active',
                'show_on_homepage' => false,
                'published_at' => now()->subDays(1),
                'sort_order' => 3,
            ],
            [
                'title' => 'Diving in the Red Sea: A Complete Guide',
                'slug' => 'diving-red-sea-complete-guide',
                'short_description' => 'Discover the underwater wonders of the Red Sea, one of the world\'s premier diving destinations with incredible marine biodiversity.',
                'category' => 'Red Sea & Diving',
                'description' => '<p>The Red Sea is renowned as one of the world\'s best diving destinations, offering crystal-clear waters, vibrant coral reefs, and an incredible diversity of marine life.</p><h3>Why Dive in the Red Sea?</h3><p>The Red Sea boasts over 1,200 species of fish and 200 species of coral. The water visibility often exceeds 30 meters, and the water temperature remains warm year-round, making it perfect for diving.</p><h3>Best Diving Spots</h3><h4>Sharm El Sheikh</h4><p>Home to famous dive sites like the Straits of Tiran and Ras Mohammed National Park, Sharm El Sheikh offers world-class diving opportunities for all skill levels.</p><h4>Hurghada</h4><p>Hurghada is another excellent diving destination with numerous dive centers and sites suitable for beginners and advanced divers alike.</p><h4>Dahab</h4><p>Known for the famous Blue Hole, Dahab attracts experienced divers seeking challenging dives and unique underwater formations.</p><h3>Marine Life</h3><p>Divers can encounter a variety of marine life including colorful reef fish, sharks, dolphins, turtles, and even the occasional dugong. The coral formations are among the most beautiful in the world.</p><h3>Diving Tips</h3><p>Whether you\'re a beginner or an experienced diver, the Red Sea has something to offer. Many dive centers provide certification courses, and guided dives are available for all levels.</p><p>Plan your diving adventure in the Red Sea and discover the underwater paradise that awaits beneath the surface!</p>',
                'meta_title' => 'Red Sea Diving Guide - Best Spots & Marine Life',
                'meta_description' => 'Complete guide to diving in the Red Sea including best dive sites, marine life, and tips for divers of all levels.',
                'meta_keywords' => 'Red Sea diving, Sharm El Sheikh diving, Hurghada diving, Egypt diving, Red Sea marine life',
                'author' => 'Diving Expert',
                'status' => 'active',
                'show_on_homepage' => true,
                'published_at' => now()->subDays(7),
                'sort_order' => 4,
            ],
            [
                'title' => 'Exploring Ancient Egyptian Temples: A Historical Journey',
                'slug' => 'exploring-ancient-egyptian-temples-historical-journey',
                'short_description' => 'Take a journey through time as we explore the magnificent temples of ancient Egypt and their fascinating history.',
                'category' => 'Cairo & Pyramids',
                'description' => '<p>Egypt\'s ancient temples are among the most impressive architectural achievements in human history. These magnificent structures tell the stories of pharaohs, gods, and ancient civilizations.</p><h3>Karnak Temple Complex</h3><p>The Karnak Temple Complex in Luxor is one of the largest religious sites ever constructed. It was built over 2,000 years and features massive columns, obelisks, and intricate hieroglyphics.</p><h3>Luxor Temple</h3><p>Located on the east bank of the Nile, Luxor Temple is particularly beautiful when illuminated at night. It was dedicated to the Theban Triad of Amun, Mut, and Khonsu.</p><h3>Abu Simbel Temples</h3><p>The Abu Simbel temples, built by Ramesses II, are famous for their massive statues and the incredible feat of moving them to higher ground to save them from flooding.</p><h3>Temple of Hatshepsut</h3><p>This unique mortuary temple was built for Queen Hatshepsut, one of Egypt\'s few female pharaohs. Its design is strikingly modern and blends beautifully with the surrounding cliffs.</p><h3>Philae Temple</h3><p>Dedicated to the goddess Isis, Philae Temple was relocated to Agilkia Island to save it from the rising waters of Lake Nasser.</p><p>Each temple tells a unique story and offers insights into ancient Egyptian religion, architecture, and daily life. Visiting these temples is like stepping back in time.</p>',
                'meta_title' => 'Ancient Egyptian Temples - Historical Guide & Travel Tips',
                'meta_description' => 'Explore the magnificent temples of ancient Egypt including Karnak, Luxor, Abu Simbel, and more. Complete historical guide.',
                'meta_keywords' => 'Egyptian temples, Karnak Temple, Luxor Temple, Abu Simbel, ancient Egypt temples',
                'author' => 'History Enthusiast',
                'status' => 'active',
                'show_on_homepage' => false,
                'published_at' => now()->subDays(10),
                'sort_order' => 5,
            ],
            [
                'title' => 'Nile River Cruise: Experience Egypt from the Water',
                'slug' => 'nile-river-cruise-experience-egypt-water',
                'short_description' => 'Discover the magic of Egypt through a Nile River cruise, combining luxury travel with ancient history and stunning landscapes.',
                'category' => 'Nile Cruises',
                'description' => '<p>A Nile River cruise is one of the most romantic and relaxing ways to explore Egypt. As you sail along the world\'s longest river, you\'ll witness ancient temples, lush landscapes, and traditional villages.</p><h3>What to Expect</h3><p>Modern Nile cruises offer comfortable accommodations, fine dining, and guided tours to major attractions along the river. Most cruises last 3 to 7 days and travel between Luxor and Aswan.</p><h3>Highlights of a Nile Cruise</h3><h4>Valley of the Kings</h4><p>Visit the tombs of pharaohs in the Valley of the Kings, including the famous tomb of Tutankhamun.</p><h4>Edfu Temple</h4><p>One of the best-preserved temples in Egypt, Edfu Temple is dedicated to the falcon god Horus.</p><h4>Kom Ombo Temple</h4><p>This unique double temple is dedicated to both Sobek (crocodile god) and Horus.</p><h3>Best Time for a Nile Cruise</h3><p>The best time for a Nile cruise is from October to April when the weather is pleasant. However, cruises operate year-round, and summer cruises often offer better prices.</p><h3>What\'s Included</h3><p>Most Nile cruises include accommodation, meals, guided tours, and entertainment. Some also include flights and transfers.</p><p>A Nile River cruise offers a unique perspective on Egypt\'s history and culture. It\'s an experience you\'ll never forget!</p>',
                'meta_title' => 'Nile River Cruise Guide - Luxury Travel & Ancient History',
                'meta_description' => 'Discover the best Nile River cruises in Egypt. Complete guide to luxury cruises, itineraries, and what to expect.',
                'meta_keywords' => 'Nile cruise, Egypt cruise, Nile River cruise, Luxor Aswan cruise, Egypt travel',
                'author' => 'Travel Expert',
                'status' => 'active',
                'show_on_homepage' => true,
                'published_at' => now()->subDays(2),
                'sort_order' => 6,
            ],
            [
                'title' => 'Shopping in Egypt: Best Souvenirs and Where to Buy Them',
                'slug' => 'shopping-egypt-best-souvenirs-where-buy',
                'short_description' => 'Find the perfect souvenirs from your Egyptian adventure, from traditional crafts to modern treasures.',
                'category' => 'Cairo & Pyramids',
                'description' => '<p>Shopping in Egypt is an adventure in itself. From bustling bazaars to modern malls, Egypt offers a wide variety of unique souvenirs and local products.</p><h3>Traditional Souvenirs</h3><h4>Papyrus Art</h4><p>Authentic papyrus paintings make excellent souvenirs. Look for shops that demonstrate the traditional papyrus-making process.</p><h4>Alabaster Products</h4><p>Luxor is famous for its alabaster products, including vases, lamps, and decorative items. These make beautiful and unique gifts.</p><h4>Perfume Oils</h4><p>Egypt is known for its high-quality perfume oils. Visit a perfume shop where you can create custom blends or purchase traditional scents.</p><h3>Where to Shop</h3><h4>Khan El Khalili Bazaar</h4><p>Cairo\'s famous bazaar is a must-visit for shoppers. Here you\'ll find everything from spices and jewelry to traditional crafts and antiques.</p><h4>Luxor Souk</h4><p>The souk in Luxor offers a more relaxed shopping experience with friendly vendors and good prices.</p><h3>Bargaining Tips</h3><p>Bargaining is expected in Egyptian markets. Start by offering about half the asking price and negotiate from there. Be friendly and respectful during the process.</p><h3>What to Avoid</h3><p>Avoid buying antiquities or items made from endangered species. Stick to modern replicas and traditional crafts.</p><p>Take home a piece of Egypt with you by choosing the perfect souvenirs from your trip!</p>',
                'meta_title' => 'Shopping in Egypt - Best Souvenirs & Shopping Guide',
                'meta_description' => 'Complete guide to shopping in Egypt including best souvenirs, where to shop, and bargaining tips for travelers.',
                'meta_keywords' => 'Egypt shopping, Egyptian souvenirs, Khan El Khalili, Egypt shopping guide',
                'author' => 'Shopping Guide',
                'status' => 'active',
                'show_on_homepage' => false,
                'published_at' => now()->subDays(4),
                'sort_order' => 7,
            ],
            [
                'title' => 'Safety Tips for Traveling in Egypt',
                'slug' => 'safety-tips-traveling-egypt',
                'short_description' => 'Essential safety tips and travel advice to ensure a safe and enjoyable trip to Egypt.',
                'category' => 'Travel Tips',
                'description' => '<p>Egypt is generally a safe destination for travelers, but like any country, it\'s important to be aware of your surroundings and follow basic safety guidelines.</p><h3>General Safety Tips</h3><h4>Stay Informed</h4><p>Check travel advisories before your trip and stay updated on current events. Register with your embassy if recommended.</p><h4>Respect Local Customs</h4><p>Dress modestly, especially when visiting religious sites. Be respectful of local customs and traditions.</p><h3>Health and Hygiene</h3><p>Drink bottled water and avoid tap water. Be cautious with street food, though it\'s generally safe. Consider travel insurance that covers medical emergencies.</p><h3>Transportation Safety</h3><p>Use reputable transportation services. When taking taxis, agree on the fare beforehand or use metered taxis. Be cautious when crossing streets, especially in Cairo.</p><h3>Protecting Your Belongings</h3><p>Keep valuables secure and avoid displaying expensive items. Use hotel safes for important documents and valuables.</p><h3>Emergency Contacts</h3><p>Save important numbers including your embassy, hotel, and local emergency services. Keep copies of important documents in a safe place.</p><p>By following these safety tips, you can enjoy a worry-free trip to Egypt and focus on creating amazing memories!</p>',
                'meta_title' => 'Egypt Travel Safety Tips - Complete Safety Guide',
                'meta_description' => 'Essential safety tips for traveling in Egypt including health, transportation, and general safety advice for tourists.',
                'meta_keywords' => 'Egypt safety, Egypt travel safety, Egypt travel tips, safe travel Egypt',
                'author' => 'Safety Expert',
                'status' => 'active',
                'show_on_homepage' => false,
                'published_at' => now()->subDays(6),
                'sort_order' => 8,
            ],
        ];

        // Ensure upload directory exists
        $uploadDir = public_path('uploads/blogs');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $sourceDir = public_path('assets/frontend/assets/images/blogs');
        $blogImages = ['01.png', '02.png', '03.png', '04.png', '05.png', '06.png', '07.png', '08.png'];

        foreach ($blogs as $index => $blogData) {
            $blog = Blog::firstOrCreate(
                ['slug' => $blogData['slug']],
                $blogData
            );

            // Add cover image if it doesn't exist
            if (!$blog->cover_image && isset($blogImages[$index])) {
                $imageName = $blogImages[$index];
                $sourcePath = $sourceDir . '/' . $imageName;
                if (file_exists($sourcePath)) {
                    $destinationPath = $uploadDir . '/' . $imageName;
                    copy($sourcePath, $destinationPath);
                    $blog->update(['cover_image' => $imageName]);
                }
            }
        }

        $this->command->info('Blogs seeded successfully!');
    }
}
