<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Discover Amazing Travel Destinations',
                'description' => 'Explore the world with our amazing travel packages. From tropical beaches to mountain adventures, we have something for everyone.',
                'image' => 'hero-banner.png',
                'status' => 'active',
                'sort_order' => 1,
                'link' => route('home'),
                'button_text' => 'Explore Now',
            ],
            [
                'title' => 'Adventure Awaits You',
                'description' => 'Embark on thrilling adventures and create unforgettable memories. Our expert guides will ensure you have the experience of a lifetime.',
                'image' => 'destination-banner.png',
                'status' => 'active',
                'sort_order' => 2,
                'link' => route('home'),
                'button_text' => 'Start Adventure',
            ],
            [
                'title' => 'Luxury Travel Experiences',
                'description' => 'Indulge in luxury travel experiences with our premium packages. Enjoy world-class accommodations and personalized service.',
                'image' => 'destination-01.png',
                'status' => 'active',
                'sort_order' => 3,
                'link' => route('home'),
                'button_text' => 'Book Now',
            ],
            [
                'title' => 'Cultural Tours & Heritage',
                'description' => 'Immerse yourself in rich cultures and explore historical heritage sites around the world.',
                'image' => 'destination-02.png',
                'status' => 'active',
                'sort_order' => 4,
                'link' => route('home'),
                'button_text' => 'Learn More',
            ],
            [
                'title' => 'Beach Paradise',
                'description' => 'Relax and unwind at the most beautiful beaches in the world. Perfect for your next vacation.',
                'image' => 'destination-03.png',
                'status' => 'active',
                'sort_order' => 5,
                'link' => route('home'),
                'button_text' => 'Book Vacation',
            ],
        ];

        // Ensure upload directory exists
        $uploadDir = public_path('uploads/sliders');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $sourceDir = public_path('assets/frontend/assets/images');

        foreach ($sliders as $sliderData) {
            $imageName = $sliderData['image'];

            // Copy image first
            $sourcePath = $sourceDir . '/' . $imageName;
            if (file_exists($sourcePath)) {
                $destinationPath = $uploadDir . '/' . $imageName;
                if (!file_exists($destinationPath)) {
                    copy($sourcePath, $destinationPath);
                }
            }

            $slider = Slider::firstOrCreate(
                ['sort_order' => $sliderData['sort_order']],
                $sliderData
            );

            // Update image if it was just created or doesn't exist
            if (!$slider->image || !file_exists(public_path('uploads/sliders/' . $slider->image))) {
                if (file_exists($sourcePath)) {
                    $slider->update(['image' => $imageName]);
                }
            }
        }

        $this->command->info('Sliders seeded successfully!');
    }
}
