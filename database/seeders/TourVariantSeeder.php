<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\TourVariant;
use Illuminate\Database\Seeder;

class TourVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variants = [
            [
                'title' => 'Sunrise Option',
                'description' => 'Early start with breakfast included.',
                'image' => 'variant-01.jpg',
                'additional_duration' => 2,
                'additional_duration_type' => 'hours',
                'additional_price' => 25.00,
                'status' => 'active',
                'sort_order' => 1,
            ],
            [
                'title' => 'Private Guide',
                'description' => 'Dedicated guide for your group.',
                'image' => 'variant-02.jpg',
                'additional_duration' => 0,
                'additional_duration_type' => 'hours',
                'additional_price' => 45.00,
                'status' => 'active',
                'sort_order' => 2,
            ],
            [
                'title' => 'Luxury Transport',
                'description' => 'Upgrade to premium vehicle with Wi‑Fi.',
                'image' => 'variant-03.jpg',
                'additional_duration' => 0,
                'additional_duration_type' => 'hours',
                'additional_price' => 60.00,
                'status' => 'active',
                'sort_order' => 3,
            ],
            [
                'title' => 'Lunch Included',
                'description' => 'Local cuisine set menu.',
                'image' => 'variant-04.jpg',
                'additional_duration' => 1,
                'additional_duration_type' => 'hours',
                'additional_price' => 15.00,
                'status' => 'active',
                'sort_order' => 4,
            ],
            [
                'title' => 'Sunset Extension',
                'description' => 'Stay for sunset photography.',
                'image' => 'variant-05.jpg',
                'additional_duration' => 3,
                'additional_duration_type' => 'hours',
                'additional_price' => 35.00,
                'status' => 'active',
                'sort_order' => 5,
            ],
        ];

        $variantIds = [];
        foreach ($variants as $variant) {
            $model = TourVariant::updateOrCreate(
                ['title' => $variant['title']],
                $variant
            );
            $variantIds[] = $model->id;
        }

        // Attach variants to the first few tours if they exist
        $tours = Tour::take(3)->get();
        foreach ($tours as $tour) {
            $tour->variants()->syncWithoutDetaching($variantIds);
        }
    }
}
