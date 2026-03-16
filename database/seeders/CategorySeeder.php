<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // List of allowed category slugs (only these will be kept)
        $allowedSlugs = [ 'tour-egypt-packages'];

        // Delete all categories that are not in the allowed list
        Category::whereNotIn('slug', $allowedSlugs)->delete();

        $categories = [
            [
                'name' => 'Tour Egypt Packages',
                'slug' => 'tour-egypt-packages',
                'description' => '<p>Comprehensive travel packages covering Egypt\'s top destinations. All-inclusive tours designed to give you the ultimate Egyptian experience.</p>',
                'image' => 'destination-03.png',
                'status' => 'active',
                'sort_order' => 3,
                'grid_columns' => '4',
                'header_background_color' => '#f0f0f0',
                'header_text_color' => '#333333',
                'card_style' => 'default',
                'show_breadcrumb' => true,
                'show_description' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            $image = $categoryData['image'] ?? null;
            unset($categoryData['image']);

            // Check if image exists before creating category
            if ($image) {
                $sourcePath = public_path('assets/frontend/assets/images/' . $image);
                if (!file_exists($sourcePath)) {
                    // Skip this category if image doesn't exist
                    continue;
                }
            } else {
                // Skip categories without images
                continue;
            }

            $category = Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );

            // Copy image if provided and category doesn't have image
            if ($image && !$category->image) {
                $destinationPath = public_path('uploads/categories/' . $image);
                if (!file_exists(public_path('uploads/categories'))) {
                    mkdir(public_path('uploads/categories'), 0755, true);
                }
                copy($sourcePath, $destinationPath);
                $category->update(['image' => $image]);
            }
        }

        $this->command->info('Categories seeded successfully!');
    }
}
