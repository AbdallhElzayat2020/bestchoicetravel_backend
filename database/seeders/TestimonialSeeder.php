<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Ahmed Mohamed',
                'description' => 'Amazing travel experience! The team was professional and the destinations were breathtaking. Highly recommend their services for anyone looking for an unforgettable adventure.',
                'image' => 'testimonial1.jpg',
                'job_title' => 'Travel Enthusiast',
                'company' => 'Adventure Seekers',
                'rating' => 5,
                'status' => 'active',
                'sort_order' => 1,
            ],
            [
                'name' => 'Fatima Ali',
                'description' => 'I had the most wonderful vacation thanks to this travel agency. Everything was perfectly organized, from flights to accommodations. The guides were knowledgeable and friendly.',
                'image' => 'testimonial2.jpg',
                'job_title' => 'Marketing Manager',
                'company' => 'Tech Solutions Inc.',
                'rating' => 5,
                'status' => 'active',
                'sort_order' => 2,
            ],
            [
                'name' => 'Mohamed Hassan',
                'description' => 'Outstanding service and attention to detail. The cultural tours were eye-opening and the local experiences were authentic. Will definitely book again!',
                'image' => 'testimonial3.jpg',
                'job_title' => 'Photographer',
                'company' => 'Creative Studio',
                'rating' => 4,
                'status' => 'active',
                'sort_order' => 3,
            ],
            [
                'name' => 'Sara Ibrahim',
                'description' => 'The beach holiday package exceeded all my expectations. Beautiful locations, excellent hotels, and great value for money. Perfect for a relaxing getaway.',
                'image' => 'testimonial4.jpg',
                'job_title' => 'Business Owner',
                'company' => 'Fashion Boutique',
                'rating' => 5,
                'status' => 'active',
                'sort_order' => 4,
            ],
            [
                'name' => 'Omar Khaled',
                'description' => 'Professional service from start to finish. The mountain expedition was challenging but rewarding. The team ensured our safety throughout the journey.',
                'image' => 'testimonial5.jpg',
                'job_title' => 'Engineer',
                'company' => 'Construction Corp',
                'rating' => 5,
                'status' => 'active',
                'sort_order' => 5,
            ],
            [
                'name' => 'Layla Mahmoud',
                'description' => 'Great experience overall. The city break tour was well-planned and covered all the important attractions. The guide was excellent and very informative.',
                'image' => 'testimonial6.jpg',
                'job_title' => 'Teacher',
                'company' => 'Education Center',
                'rating' => 4,
                'status' => 'inactive',
                'sort_order' => 6,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }

        $this->command->info('Testimonials seeded successfully!');
        $this->command->warn('Note: Please add actual images to public/uploads/testimonials/ directory with the names: testimonial1.jpg, testimonial2.jpg, etc.');
    }
}
