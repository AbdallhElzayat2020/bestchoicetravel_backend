<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\TourDay;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TourDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cairo and Giza Pyramids Tour - 3 days
        $cairoTour = Tour::where('slug', 'cairo-and-giza-pyramids-tour')->first();
        if ($cairoTour) {
            $cairoDays = [
                [
                    'tour_id' => $cairoTour->id,
                    'day_number' => 1,
                    'day_title' => 'Day 1: Arrival in Cairo',
                    'details' => '<p>Welcome to the mystical lands of Egypt, where the Pharaohs ruled for thousands of years. Upon your arrival at Cairo International Airport, your tour manager will meet and assist you and ease the process by helping you to get the entry visa. You will then be escorted through the bustling streets of Cairo in an exclusive air-conditioned vehicle.</p><p>Once you reach your chosen hotel according to your accommodation plan whether it will be overlooking the Great Pyramids of Giza like Hilton Pyramids Golf Hotel or in Khan El Khalili, like Le Riad Luxury Boutique Hotel, your tour manager will assist you with your check-in and double-check your itinerary with you to establish and confirm all the pick-up times for all your activities during your trip.</p><p><strong>Overnight in Cairo.</strong></p><p><strong>Welcome drink included.</strong></p>',
                    'sort_order' => 1,
                ],
                [
                    'tour_id' => $cairoTour->id,
                    'day_number' => 2,
                    'day_title' => 'Day 2: Giza Pyramids, Sphinx & Egyptian Museum',
                    'details' => '<p>After breakfast at your hotel, your Egyptologist guide will pick you up to start your full-day tour. Begin with a visit to the Giza Plateau, home to the Great Pyramids of Giza - the only remaining wonder of the ancient world. Marvel at the Great Pyramid of Khufu, the Pyramid of Khafre, and the Pyramid of Menkaure.</p><p>Continue to the enigmatic Sphinx, the legendary guardian statue with the body of a lion and the head of a pharaoh. Learn about the mysteries surrounding this ancient monument.</p><p>After lunch at a local restaurant, proceed to the Egyptian Museum, which houses over 120,000 artifacts including the treasures of Tutankhamun. See the golden mask, jewelry, and other priceless items discovered in his tomb.</p><p><strong>Overnight in Cairo.</strong></p>',
                    'sort_order' => 2,
                ],
                [
                    'tour_id' => $cairoTour->id,
                    'day_number' => 3,
                    'day_title' => 'Day 3: Khan El Khalili Bazaar & Departure',
                    'details' => '<p>After breakfast, explore the historic Khan El Khalili bazaar, one of the oldest markets in the Middle East. Wander through narrow alleys filled with shops selling spices, perfumes, jewelry, and traditional crafts. Experience the vibrant atmosphere and practice your bargaining skills.</p><p>Enjoy a traditional Egyptian lunch before heading to Cairo International Airport for your departure flight, taking with you unforgettable memories of ancient Egypt.</p><p><strong>Breakfast included.</strong></p>',
                    'sort_order' => 3,
                ],
            ];

            foreach ($cairoDays as $day) {
                TourDay::create($day);
            }
        }

        // Luxor and Aswan Nile Cruise - 5 days
        $luxorTour = Tour::where('slug', 'luxor-and-aswan-nile-cruise')->first();
        if ($luxorTour) {
            $luxorDays = [
                [
                    'tour_id' => $luxorTour->id,
                    'day_number' => 1,
                    'day_title' => 'Day 1: Arrival in Luxor & Boarding Cruise',
                    'details' => '<p>Arrive at Luxor Airport where you will be met and transferred to your Nile cruise ship. After check-in and lunch on board, begin your exploration of Luxor.</p><p>Visit the magnificent Karnak Temple Complex, the largest religious site ever built. Walk through the Great Hypostyle Hall with its 134 massive columns, and learn about the pharaohs who built this incredible temple over 2000 years.</p><p>Continue to Luxor Temple, beautifully illuminated at night, dedicated to the Theban Triad of Amun, Mut, and Khonsu.</p><p><strong>Overnight on board in Luxor.</strong></p>',
                    'sort_order' => 1,
                ],
                [
                    'tour_id' => $luxorTour->id,
                    'day_number' => 2,
                    'day_title' => 'Day 2: Valley of the Kings & Colossi of Memnon',
                    'details' => '<p>Early morning optional hot air balloon ride over the West Bank (available at extra cost). After breakfast, cross to the West Bank to visit the Valley of the Kings, the burial place of pharaohs including Tutankhamun, Ramesses the Great, and Seti I.</p><p>Explore the beautifully decorated tombs with their colorful hieroglyphics and learn about the ancient Egyptian beliefs in the afterlife. Visit the Temple of Hatshepsut, the only female pharaoh, built into the cliffs of Deir el-Bahari.</p><p>See the Colossi of Memnon, two massive stone statues of Amenhotep III that have stood for over 3,400 years.</p><p><strong>Overnight on board, sailing to Edfu.</strong></p>',
                    'sort_order' => 2,
                ],
                [
                    'tour_id' => $luxorTour->id,
                    'day_number' => 3,
                    'day_title' => 'Day 3: Edfu & Kom Ombo Temples',
                    'details' => '<p>After breakfast, visit the Temple of Horus at Edfu, one of the best-preserved temples in Egypt. Dedicated to the falcon god Horus, this temple provides incredible insight into ancient Egyptian religion and architecture.</p><p>Continue sailing to Kom Ombo to visit the unique double temple dedicated to Sobek (the crocodile god) and Horus the Elder. This temple is perfectly symmetrical, with two identical entrances, halls, and sanctuaries.</p><p>Enjoy the beautiful scenery along the Nile as you sail towards Aswan. Relax on the sun deck and watch the traditional feluccas sail by.</p><p><strong>Overnight on board in Aswan.</strong></p>',
                    'sort_order' => 3,
                ],
                [
                    'tour_id' => $luxorTour->id,
                    'day_number' => 4,
                    'day_title' => 'Day 4: Aswan - Philae Temple & High Dam',
                    'details' => '<p>After breakfast, visit the High Dam, an engineering marvel that created Lake Nasser, one of the largest man-made lakes in the world. Learn about the dam\'s impact on Egypt\'s agriculture and electricity production.</p><p>Take a motorboat to the beautiful Philae Temple, dedicated to the goddess Isis. This temple was relocated to its current location on Agilkia Island to save it from flooding when the High Dam was built.</p><p>Optional visit to a Nubian village to experience the unique culture and traditions of the Nubian people. Enjoy a traditional Nubian lunch and learn about their way of life.</p><p><strong>Overnight on board in Aswan.</strong></p>',
                    'sort_order' => 4,
                ],
                [
                    'tour_id' => $luxorTour->id,
                    'day_number' => 5,
                    'day_title' => 'Day 5: Disembarkation & Departure',
                    'details' => '<p>After breakfast on board, disembark from your cruise ship. Transfer to Aswan Airport for your departure flight, or continue with optional extensions to Abu Simbel or back to Cairo.</p><p>Take with you unforgettable memories of sailing the legendary Nile and exploring the magnificent temples of ancient Egypt.</p><p><strong>Breakfast included.</strong></p>',
                    'sort_order' => 5,
                ],
            ];

            foreach ($luxorDays as $day) {
                TourDay::create($day);
            }
        }

        // Hurghada Red Sea Paradise - 7 days
        $hurghadaTour = Tour::where('slug', 'hurghada-red-sea-paradise')->first();
        if ($hurghadaTour) {
            $hurghadaDays = [
                [
                    'tour_id' => $hurghadaTour->id,
                    'day_number' => 1,
                    'day_title' => 'Day 1: Arrival in Hurghada',
                    'details' => '<p>Welcome to Hurghada, the Red Sea paradise! Upon arrival at Hurghada International Airport, you will be transferred to your beachfront resort. Check in and enjoy the beautiful views of the Red Sea.</p><p>Spend the rest of the day relaxing on the beach, taking a dip in the crystal-clear waters, or enjoying the resort facilities. In the evening, enjoy a welcome dinner at one of the resort\'s restaurants.</p><p><strong>Overnight in Hurghada.</strong></p>',
                    'sort_order' => 1,
                ],
                [
                    'tour_id' => $hurghadaTour->id,
                    'day_number' => 2,
                    'day_title' => 'Day 2: Snorkeling Adventure',
                    'details' => '<p>After breakfast, embark on a snorkeling boat trip to explore the vibrant coral reefs of the Red Sea. The Red Sea is home to over 1,200 species of fish and 200 species of coral, making it one of the world\'s best diving destinations.</p><p>Swim among colorful fish, see beautiful coral formations, and if you\'re lucky, spot dolphins or sea turtles. Equipment and instruction provided for beginners. Lunch will be served on board the boat.</p><p>Return to the resort in the afternoon for relaxation and evening activities.</p><p><strong>Overnight in Hurghada.</strong></p>',
                    'sort_order' => 2,
                ],
                [
                    'tour_id' => $hurghadaTour->id,
                    'day_number' => 3,
                    'day_title' => 'Day 3: Desert Safari Adventure',
                    'details' => '<p>Experience the beauty of the Eastern Desert with a thrilling desert safari. Ride in a 4x4 vehicle through sand dunes, visit a Bedouin camp, and learn about traditional desert life.</p><p>Enjoy camel rides, try sandboarding, and watch a beautiful desert sunset. In the evening, enjoy a traditional Bedouin dinner under the stars with live music and entertainment.</p><p>Return to the resort late in the evening.</p><p><strong>Overnight in Hurghada.</strong></p>',
                    'sort_order' => 3,
                ],
                [
                    'tour_id' => $hurghadaTour->id,
                    'day_number' => 4,
                    'day_title' => 'Day 4: Free Day & Water Sports',
                    'details' => '<p>Enjoy a free day to relax and explore at your own pace. Try various water sports available at the resort including windsurfing, parasailing, kayaking, or paddleboarding.</p><p>Relax by the pool, enjoy spa treatments, or simply soak up the sun on the beautiful beach. The resort offers various activities and entertainment throughout the day.</p><p>In the evening, enjoy dinner at one of the resort\'s specialty restaurants.</p><p><strong>Overnight in Hurghada.</strong></p>',
                    'sort_order' => 4,
                ],
                [
                    'tour_id' => $hurghadaTour->id,
                    'day_number' => 5,
                    'day_title' => 'Day 5: Giftun Island Excursion',
                    'details' => '<p>Take a boat trip to Giftun Island, a protected marine park known for its pristine beaches and excellent snorkeling. Spend the day swimming, snorkeling, and relaxing on the white sandy beaches.</p><p>Enjoy a delicious BBQ lunch on the island and take in the stunning natural beauty. The clear turquoise waters and abundant marine life make this a perfect day trip.</p><p>Return to Hurghada in the late afternoon.</p><p><strong>Overnight in Hurghada.</strong></p>',
                    'sort_order' => 5,
                ],
                [
                    'tour_id' => $hurghadaTour->id,
                    'day_number' => 6,
                    'day_title' => 'Day 6: Diving Experience',
                    'details' => '<p>For certified divers, enjoy a full-day diving trip to some of Hurghada\'s best dive sites. For beginners, try a discovery dive with professional instructors in shallow waters.</p><p>Explore underwater caves, see colorful coral gardens, and encounter diverse marine life including angelfish, parrotfish, and maybe even a reef shark. Two dives included with lunch on board.</p><p>Return to the resort in the afternoon for relaxation.</p><p><strong>Overnight in Hurghada.</strong></p>',
                    'sort_order' => 6,
                ],
                [
                    'tour_id' => $hurghadaTour->id,
                    'day_number' => 7,
                    'day_title' => 'Day 7: Departure',
                    'details' => '<p>After breakfast, enjoy some final moments on the beach or by the pool before checking out. Transfer to Hurghada International Airport for your departure flight, taking with you wonderful memories of the Red Sea paradise.</p><p><strong>Breakfast included.</strong></p>',
                    'sort_order' => 7,
                ],
            ];

            foreach ($hurghadaDays as $day) {
                TourDay::create($day);
            }
        }

        // Dubai City Tour & Desert Safari - 4 days
        $dubaiTour = Tour::where('slug', 'dubai-city-tour-desert-safari')->first();
        if ($dubaiTour) {
            $dubaiDays = [
                [
                    'tour_id' => $dubaiTour->id,
                    'day_number' => 1,
                    'day_title' => 'Day 1: Arrival in Dubai & City Tour',
                    'details' => '<p>Welcome to Dubai, the city of superlatives! Upon arrival at Dubai International Airport, you will be transferred to your hotel in the city center. After check-in and refreshment, begin your exploration of this modern metropolis.</p><p>Visit the iconic Burj Khalifa, the world\'s tallest building. Take the high-speed elevator to the 124th floor observation deck for breathtaking panoramic views of the city, desert, and ocean.</p><p>Explore the Dubai Mall, one of the world\'s largest shopping centers, and watch the spectacular Dubai Fountain show in the evening.</p><p><strong>Overnight in Dubai.</strong></p>',
                    'sort_order' => 1,
                ],
                [
                    'tour_id' => $dubaiTour->id,
                    'day_number' => 2,
                    'day_title' => 'Day 2: Old Dubai & Traditional Souks',
                    'details' => '<p>After breakfast, explore the historic side of Dubai. Visit the Dubai Museum located in Al Fahidi Fort, the oldest existing building in Dubai. Learn about the city\'s transformation from a small fishing village to a global metropolis.</p><p>Take an abra (traditional water taxi) across Dubai Creek to the vibrant spice and gold souks. Experience the sights, sounds, and aromas of these traditional markets. Marvel at the incredible displays of gold jewelry and shop for spices, perfumes, and souvenirs.</p><p>Enjoy a traditional Emirati lunch before returning to your hotel.</p><p><strong>Overnight in Dubai.</strong></p>',
                    'sort_order' => 2,
                ],
                [
                    'tour_id' => $dubaiTour->id,
                    'day_number' => 3,
                    'day_title' => 'Day 3: Desert Safari Adventure',
                    'details' => '<p>Experience the thrill of the Arabian Desert with an exciting desert safari. After an afternoon pickup, enjoy dune bashing in a 4x4 vehicle across the golden sand dunes.</p><p>Try sandboarding, take a camel ride, and watch a beautiful desert sunset. Visit a traditional Bedouin camp where you can get henna tattoos, try shisha, and dress in traditional Arabic attire.</p><p>Enjoy a delicious BBQ dinner under the stars while watching live entertainment including belly dancing and Tanoura shows. This is an unforgettable desert experience!</p><p><strong>Overnight in Dubai.</strong></p>',
                    'sort_order' => 3,
                ],
                [
                    'tour_id' => $dubaiTour->id,
                    'day_number' => 4,
                    'day_title' => 'Day 4: Palm Jumeirah & Departure',
                    'details' => '<p>After breakfast, visit the iconic Palm Jumeirah, an artificial archipelago shaped like a palm tree. See the luxurious Atlantis The Palm resort and enjoy the beautiful beaches.</p><p>Take a monorail ride for stunning views of the Palm and the surrounding area. Visit the Dubai Marina and JBR (Jumeirah Beach Residence) for shopping and dining.</p><p>Transfer to Dubai International Airport for your departure flight, taking with you memories of this incredible city that seamlessly blends tradition with modernity.</p><p><strong>Breakfast included.</strong></p>',
                    'sort_order' => 4,
                ],
            ];

            foreach ($dubaiDays as $day) {
                TourDay::create($day);
            }
        }
    }
}
