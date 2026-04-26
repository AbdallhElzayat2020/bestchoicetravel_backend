<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Static pages for SEO management (including Home)
        $pages = [
            [
                'slug' => 'home',
                'name' => 'Home',
                'content' => null,
                'meta_title' => 'Travel Egypt - Discover Ancient Wonders',
                'meta_description' => 'Plan your dream trip to Egypt with tailor-made tours, Nile cruises, Cairo, Luxor, Aswan and Red Sea escapes.',
                'meta_author' => 'Travel Egypt',
                'meta_keywords' => 'Egypt tours, Nile cruise, Cairo, Luxor, Aswan, Red Sea, travel Egypt',
                'status' => 'active',
                'sort_order' => 0,
            ],
            [
                'slug' => 'about-us',
                'name' => 'About Us',
                'content' => null, // المحتوى ثابت في blade file
                'meta_title' => 'About Us - Travel Website',
                'meta_description' => 'Learn more about our travel agency and our mission to provide the best travel experiences.',
                'meta_author' => 'Travel Website',
                'meta_keywords' => 'about, travel agency, company',
                'status' => 'active',
                'sort_order' => 1,
            ],
            [
                'slug' => 'faqs',
                'name' => 'FAQs',
                'content' => null, // المحتوى ثابت في blade file
                'meta_title' => 'FAQs - Frequently Asked Questions',
                'meta_description' => 'Find answers to your most common travel questions. Get information about bookings, tours, destinations, and more.',
                'meta_author' => 'Travel Website',
                'meta_keywords' => 'faq, frequently asked questions, travel questions, help',
                'status' => 'active',
                'sort_order' => 2,
            ],
            [
                'slug' => 'contact-us',
                'name' => 'Contact Us',
                'content' => null, // المحتوى ثابت في blade file
                'meta_title' => 'Contact Us - Travel Website',
                'meta_description' => 'Get in touch with us for travel inquiries, bookings, and support.',
                'meta_author' => 'Travel Website',
                'meta_keywords' => 'contact, travel contact, inquiry, support',
                'status' => 'active',
                'sort_order' => 3,
            ],
            [
                'slug' => 'blogs',
                'name' => 'Blogs',
                'content' => null, // المحتوى ثابت في blade file
                'meta_title' => 'Travel Blogs - Travel Website',
                'meta_description' => 'Read our latest travel blogs, tips, and destination guides.',
                'meta_author' => 'Travel Website',
                'meta_keywords' => 'travel blog, tips, guides, destinations',
                'status' => 'active',
                'sort_order' => 4,
            ],
            [
                'slug' => 'terms-and-conditions',
                'name' => 'Terms and Conditions',
                'content' => '<h2>Terms and Conditions</h2><p>Welcome to our travel website. By accessing and using this website, you accept and agree to be bound by the terms and conditions set forth below.</p><h3>1. Acceptance of Terms</h3><p>By accessing this website, you acknowledge that you have read, understood, and agree to be bound by these terms and conditions.</p><h3>2. Use of Services</h3><p>Our services are provided for your personal and non-commercial use. You may not use our services for any illegal or unauthorized purpose.</p><h3>3. Booking and Cancellation</h3><p>All bookings are subject to availability and confirmation. Cancellation policies vary by tour package and will be clearly stated at the time of booking.</p><h3>4. Payment Terms</h3><p>Payment must be made in full at the time of booking unless otherwise agreed. We accept various payment methods as specified during checkout.</p><h3>5. Limitation of Liability</h3><p>We shall not be liable for any indirect, incidental, special, or consequential damages arising from your use of our services.</p>',
                'meta_title' => 'Terms and Conditions - Travel Website',
                'meta_description' => 'Read our terms and conditions for using our travel services and booking tours.',
                'meta_author' => 'Travel Website',
                'meta_keywords' => 'terms, conditions, legal, travel terms, booking terms',
                'status' => 'active',
                'sort_order' => 5,
            ],
            [
                'slug' => 'privacy-policy',
                'name' => 'Privacy Policy',
                'content' => '<h2>Privacy Policy</h2><p>We are committed to protecting your privacy. This privacy policy explains how we collect, use, and safeguard your personal information.</p><h3>1. Information We Collect</h3><p>We collect information that you provide directly to us, including your name, email address, phone number, and payment information when you make a booking.</p><h3>2. How We Use Your Information</h3><p>We use the information we collect to process your bookings, communicate with you, improve our services, and send you promotional materials if you have opted in.</p><h3>3. Information Sharing</h3><p>We do not sell, trade, or rent your personal information to third parties. We may share your information with service providers who assist us in operating our website and conducting our business.</p><h3>4. Data Security</h3><p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p><h3>5. Your Rights</h3><p>You have the right to access, update, or delete your personal information at any time. Please contact us if you wish to exercise these rights.</p><h3>6. Cookies</h3><p>We use cookies to enhance your experience on our website. You can choose to disable cookies through your browser settings, though this may affect website functionality.</p>',
                'meta_title' => 'Privacy Policy - Travel Website',
                'meta_description' => 'Learn how we collect, use, and protect your personal information when you use our travel services.',
                'meta_author' => 'Travel Website',
                'meta_keywords' => 'privacy policy, data protection, personal information, cookies',
                'status' => 'active',
                'sort_order' => 6,
            ],
            [
                'slug' => 'payment-policy',
                'name' => 'Payment Policy',
                'content' => '<h2>Payment Policy</h2><p>We aim to make payment for your Egypt travel experience as simple and secure as possible. Please read our payment policy carefully before making a booking.</p><h3>1. Deposit & Full Payment</h3><p>A deposit of 25% of the total tour price is required to confirm your booking. The remaining balance must be paid at least 30 days before the tour departure date.</p><h3>2. Accepted Payment Methods</h3><p>We accept the following payment methods: Bank Transfer (SWIFT / SEPA), Credit and Debit Cards (Visa, MasterCard), PayPal, and Western Union for special arrangements.</p><h3>3. Currency</h3><p>All prices are quoted in US Dollars (USD). Payments may also be accepted in EUR or GBP at the current exchange rate.</p><h3>4. Late Payment</h3><p>If the balance is not received 30 days before departure, we reserve the right to treat the booking as cancelled and apply the relevant cancellation charges.</p><h3>5. Cancellation & Refund</h3><p>Cancellations made more than 30 days before departure: deposit refunded minus a 10% administration fee. Cancellations 15–29 days before departure: 50% of total price charged. Cancellations less than 15 days before departure: no refund.</p><h3>6. Payment Security</h3><p>All card payments are processed through a PCI-DSS compliant payment gateway. We do not store your card details on our servers.</p>',
                'meta_title' => 'Payment Policy - Best Choice Travel',
                'meta_description' => 'Understand our payment terms, accepted methods, cancellation and refund policy for Egypt tours and Nile cruises.',
                'meta_author' => 'Best Choice Travel',
                'meta_keywords' => 'payment policy, deposit, refund, cancellation, Egypt tours payment',
                'status' => 'active',
                'sort_order' => 7,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }
    }
}
