<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What travel documents do I need?',
                'answer' => 'You will need a valid passport with at least 6 months validity from your travel date. Depending on your destination, you may also need a visa. We recommend checking visa requirements for your specific destination at least 2-3 months before your trip.',
                'status' => 'active',
                'sort_order' => 1,
            ],
            [
                'question' => 'How far in advance should I book my trip?',
                'answer' => 'We recommend booking at least 2-3 months in advance for the best prices and availability, especially during peak travel seasons. For popular destinations and holiday periods, booking 4-6 months in advance is advisable.',
                'status' => 'active',
                'sort_order' => 2,
            ],
            [
                'question' => 'What is included in the travel package?',
                'answer' => 'Our travel packages typically include accommodation, airport transfers, breakfast, and guided tours as specified in the package details. Flights, travel insurance, and personal expenses are usually not included unless stated otherwise. Please check the specific package details for a complete list of inclusions.',
                'status' => 'active',
                'sort_order' => 3,
            ],
            [
                'question' => 'Can I customize my travel itinerary?',
                'answer' => 'Yes, absolutely! We offer flexible packages that can be customized according to your preferences. You can add extra activities, extend your stay, upgrade accommodations, or modify the itinerary to suit your needs. Contact our travel consultants for personalized planning.',
                'status' => 'active',
                'sort_order' => 4,
            ],
            [
                'question' => 'What is your cancellation policy?',
                'answer' => 'Our cancellation policy varies depending on the package and timing. Generally, cancellations made 30 days or more before departure receive a full refund minus processing fees. Cancellations within 14-30 days receive a 50% refund. Cancellations less than 14 days before departure are non-refundable. Please refer to your booking confirmation for specific terms.',
                'status' => 'active',
                'sort_order' => 5,
            ],
            [
                'question' => 'Do you offer travel insurance?',
                'answer' => 'Yes, we highly recommend purchasing travel insurance for your protection. We offer comprehensive travel insurance packages that cover medical emergencies, trip cancellations, lost luggage, and other unforeseen circumstances. You can add travel insurance during the booking process.',
                'status' => 'active',
                'sort_order' => 6,
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept various payment methods including credit cards (Visa, Mastercard, American Express), debit cards, bank transfers, and online payment gateways. A deposit is usually required to confirm your booking, with the balance due 30 days before departure.',
                'status' => 'active',
                'sort_order' => 7,
            ],
            [
                'question' => 'Are group discounts available?',
                'answer' => 'Yes, we offer special group discounts for bookings of 10 or more people. Group discounts can range from 5% to 15% depending on the group size and destination. Contact our group travel specialists for customized group packages and pricing.',
                'status' => 'inactive',
                'sort_order' => 8,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        $this->command->info('FAQs seeded successfully!');
    }
}
