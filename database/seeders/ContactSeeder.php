<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Contact;
use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();

        $contacts = [
            [
                'name' => 'Ahmed Mohamed',
                'email' => 'ahmed.mohamed@example.com',
                'phone' => '+201234567890',
                'subject' => 'Inquiry about Safari Tours',
                'message' => 'I am interested in booking a safari tour. Can you provide more information about available packages and pricing?',
                'category_id' => $categories->where('slug', 'adventure-tours')->first()?->id,
                'sub_category_id' => $subCategories->where('slug', 'safari-tours')->first()?->id,
                'is_read' => false,
            ],
            [
                'name' => 'Fatima Ali',
                'email' => 'fatima.ali@example.com',
                'phone' => '+201987654321',
                'subject' => 'Beach Holiday Package',
                'message' => 'Looking for a relaxing beach holiday for my family. What are the best destinations you recommend?',
                'category_id' => $categories->where('slug', 'beach-holidays')->first()?->id,
                'sub_category_id' => $subCategories->where('slug', 'tropical-beaches')->first()?->id,
                'is_read' => false,
            ],
            [
                'name' => 'Mohamed Hassan',
                'email' => 'mohamed.hassan@example.com',
                'phone' => '+201112233445',
                'subject' => 'Cultural Tour Information',
                'message' => 'I would like to know more about your cultural tours, especially historical sites visits.',
                'category_id' => $categories->where('slug', 'cultural-tours')->first()?->id,
                'sub_category_id' => $subCategories->where('slug', 'historical-sites')->first()?->id,
                'is_read' => true,
                'read_at' => now()->subDays(2),
            ],
            [
                'name' => 'Sara Ibrahim',
                'email' => 'sara.ibrahim@example.com',
                'phone' => '+201556677889',
                'subject' => 'Mountain Climbing Expedition',
                'message' => 'I am an experienced climber looking for challenging mountain expeditions. What options do you have?',
                'category_id' => $categories->where('slug', 'mountain-expeditions')->first()?->id,
                'sub_category_id' => $subCategories->where('slug', 'mountain-climbing')->first()?->id,
                'is_read' => false,
            ],
            [
                'name' => 'Omar Khaled',
                'email' => 'omar.khaled@example.com',
                'phone' => '+201998877665',
                'subject' => 'City Break Recommendations',
                'message' => 'Planning a weekend city break. Can you suggest some European cities with good cultural attractions?',
                'category_id' => $categories->where('slug', 'city-breaks')->first()?->id,
                'sub_category_id' => $subCategories->where('slug', 'european-cities')->first()?->id,
                'is_read' => true,
                'read_at' => now()->subDays(1),
            ],
            [
                'name' => 'Nour El-Din',
                'email' => 'nour.eldin@example.com',
                'phone' => '+201223344556',
                'subject' => 'Water Sports Activities',
                'message' => 'Interested in water sports activities. What equipment is provided and what should I bring?',
                'category_id' => $categories->where('slug', 'adventure-tours')->first()?->id,
                'sub_category_id' => $subCategories->where('slug', 'water-sports')->first()?->id,
                'is_read' => false,
            ],
            [
                'name' => 'Layla Mahmoud',
                'email' => 'layla.mahmoud@example.com',
                'phone' => '+201334455667',
                'subject' => 'Group Tour Booking',
                'message' => 'We are a group of 15 people interested in a cultural tour. Do you offer group discounts?',
                'category_id' => $categories->where('slug', 'cultural-tours')->first()?->id,
                'sub_category_id' => $subCategories->where('slug', 'museums-galleries')->first()?->id,
                'is_read' => true,
                'read_at' => now()->subHours(5),
            ],
            [
                'name' => 'Youssef Mostafa',
                'email' => 'youssef.mostafa@example.com',
                'phone' => null,
                'subject' => 'General Inquiry',
                'message' => 'I would like to receive your travel brochure and more information about all your tour packages.',
                'category_id' => null,
                'sub_category_id' => null,
                'is_read' => false,
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }

        $this->command->info('Contacts seeded successfully!');
    }
}
