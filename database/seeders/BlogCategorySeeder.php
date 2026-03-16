<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Nile Cruises', 'status' => 'active', 'sort_order' => 1],
            ['name' => 'Cairo & Pyramids', 'status' => 'active', 'sort_order' => 2],
            ['name' => 'Red Sea & Diving', 'status' => 'active', 'sort_order' => 3],
            ['name' => 'Desert & Safari', 'status' => 'active', 'sort_order' => 4],
            ['name' => 'Travel Tips', 'status' => 'active', 'sort_order' => 5],
            ['name' => 'Food & Culture', 'status' => 'active', 'sort_order' => 6],
            ['name' => 'Shopping', 'status' => 'active', 'sort_order' => 7],
            ['name' => 'Safety & Practical Info', 'status' => 'active', 'sort_order' => 8],
        ];

        foreach ($categories as $data) {
            $payload = array_merge($data, [
                'slug' => Str::slug($data['name']),
            ]);

            BlogCategory::firstOrCreate(
                ['name' => $data['name']],
                $payload
            );
        }

        $this->command->info('Blog categories seeded successfully!');
    }
}

