<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'title' => 'Island Paradise',
                'slug' => 'island-paradise',
                'description' => 'Crystal clear waters, white sands, and unforgettable sunsets.',
                'cover_image' => 'destination-01.png',
                'status' => 'active',
                'show_on_homepage' => true,
                'sort_order' => 1,
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'Mountain Escape',
                'slug' => 'mountain-escape',
                'description' => 'Breathtaking peaks and misty mornings perfect for hikers.',
                'cover_image' => 'destination-02.png',
                'status' => 'active',
                'show_on_homepage' => true,
                'sort_order' => 2,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'City Lights',
                'slug' => 'city-lights',
                'description' => 'Night vibes, skyline views, and buzzing streets.',
                'cover_image' => 'destination-03.png',
                'status' => 'active',
                'show_on_homepage' => true,
                'sort_order' => 3,
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => 'Desert Adventure',
                'slug' => 'desert-adventure',
                'description' => 'Golden dunes, starry nights, and endless horizons.',
                'cover_image' => 'destination-04.png',
                'status' => 'active',
                'show_on_homepage' => true,
                'sort_order' => 4,
                'published_at' => now()->subDays(6),
            ],
            [
                'title' => 'Forest Retreat',
                'slug' => 'forest-retreat',
                'description' => 'Lush greenery and tranquil trails for a mindful escape.',
                'cover_image' => 'destination-05.png',
                'status' => 'active',
                'show_on_homepage' => true,
                'sort_order' => 5,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Cultural Journey',
                'slug' => 'cultural-journey',
                'description' => 'Historic streets, vibrant markets, and local flavors.',
                'cover_image' => 'destination-06.png',
                'status' => 'active',
                'show_on_homepage' => true,
                'sort_order' => 6,
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Snowy Peaks',
                'slug' => 'snowy-peaks',
                'description' => 'Snow-capped mountains and cozy winter retreats.',
                'cover_image' => 'destination-07.png',
                'status' => 'active',
                'show_on_homepage' => true,
                'sort_order' => 7,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Lakeside Calm',
                'slug' => 'lakeside-calm',
                'description' => 'Mirror lakes and peaceful sunrises for quiet escapes.',
                'cover_image' => 'destination-08.png',
                'status' => 'active',
                'show_on_homepage' => true,
                'sort_order' => 8,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Coastal Roads',
                'slug' => 'coastal-roads',
                'description' => 'Scenic drives along dramatic coastlines.',
                'cover_image' => 'destination-01.png',
                'status' => 'active',
                'show_on_homepage' => true,
                'sort_order' => 9,
                'published_at' => now()->subDay(),
            ],
        ];

        // Ensure upload directory exists
        $uploadDir = public_path('uploads/galleries');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $sourceDir = public_path('assets/frontend/assets/images');

        foreach ($items as $item) {
            $coverImage = $item['cover_image'];
            unset($item['cover_image']);

            $gallery = Gallery::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );

            // Copy cover image if it doesn't exist
            if (!$gallery->cover_image || !file_exists(public_path('uploads/galleries/' . $gallery->cover_image))) {
                $sourcePath = $sourceDir . '/' . $coverImage;
                if (file_exists($sourcePath)) {
                    $destinationPath = $uploadDir . '/' . $coverImage;
                    copy($sourcePath, $destinationPath);
                    $gallery->update(['cover_image' => $coverImage]);
                }
            }
        }

        $this->command->info('Galleries seeded successfully!');
    }
}
