<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscribers = [
            [
                'email' => 'ahmed.mohamed@example.com',
                'name' => 'Ahmed Mohamed',
                'is_active' => true,
                'subscribed_at' => now()->subDays(30),
            ],
            [
                'email' => 'fatima.ali@example.com',
                'name' => 'Fatima Ali',
                'is_active' => true,
                'subscribed_at' => now()->subDays(25),
            ],
            [
                'email' => 'mohamed.hassan@example.com',
                'name' => 'Mohamed Hassan',
                'is_active' => true,
                'subscribed_at' => now()->subDays(20),
            ],
            [
                'email' => 'sara.ibrahim@example.com',
                'name' => 'Sara Ibrahim',
                'is_active' => false,
                'subscribed_at' => now()->subDays(40),
                'unsubscribed_at' => now()->subDays(10),
            ],
            [
                'email' => 'omar.khaled@example.com',
                'name' => 'Omar Khaled',
                'is_active' => true,
                'subscribed_at' => now()->subDays(15),
            ],
            [
                'email' => 'nour.eldin@example.com',
                'name' => 'Nour El-Din',
                'is_active' => true,
                'subscribed_at' => now()->subDays(12),
            ],
            [
                'email' => 'layla.mahmoud@example.com',
                'name' => 'Layla Mahmoud',
                'is_active' => true,
                'subscribed_at' => now()->subDays(8),
            ],
            [
                'email' => 'youssef.mostafa@example.com',
                'name' => 'Youssef Mostafa',
                'is_active' => false,
                'subscribed_at' => now()->subDays(35),
                'unsubscribed_at' => now()->subDays(5),
            ],
            [
                'email' => 'mariam.ahmed@example.com',
                'name' => 'Mariam Ahmed',
                'is_active' => true,
                'subscribed_at' => now()->subDays(5),
            ],
            [
                'email' => 'khaled.omar@example.com',
                'name' => 'Khaled Omar',
                'is_active' => true,
                'subscribed_at' => now()->subDays(3),
            ],
        ];

        foreach ($subscribers as $subscriber) {
            Subscriber::firstOrCreate(
                ['email' => $subscriber['email']],
                $subscriber
            );
        }

        $this->command->info('Subscribers seeded successfully!');
    }
}
