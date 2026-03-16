<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\BookingFormMail;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\Setting;
use App\Services\RecaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Store a newly created booking.
     */
    public function store(Request $request, RecaptchaService $recaptcha)
    {
        // Handle selected_variants if it comes as JSON string
        $selectedVariantsInput = $request->input('selected_variants');
        if (is_string($selectedVariantsInput)) {
            $decoded = json_decode($selectedVariantsInput, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $request->merge(['selected_variants' => $decoded]);
            } else {
                $request->merge(['selected_variants' => []]);
            }
        }

        $rules = [
            'tour_id' => 'required|exists:tours,id',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'no_of_travellers' => 'required|integer|min:1',
            'accommodation_type_id' => 'nullable|exists:tour_seasonal_price_items,id',
            'selected_variants' => 'nullable|array',
            'selected_variants.*' => 'exists:tour_variants,id',
            'total_price' => 'required|numeric|min:0',
        ];

        if (RecaptchaService::isConfigured()) {
            $rules['g-recaptcha-response'] = 'required';
        }

        $validated = $request->validate($rules);

        if (RecaptchaService::isConfigured()) {
            if (!$recaptcha->verify($request->input('g-recaptcha-response'), $request->ip())) {
                return redirect()->back()
                    ->withInput($request->except('g-recaptcha-response'))
                    ->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed. Please try again.']);
            }
        }

        $tour = Tour::findOrFail($validated['tour_id']);

        // Ensure selected_variants is an array
        $selectedVariants = $validated['selected_variants'] ?? [];
        if (!is_array($selectedVariants)) {
            $selectedVariants = [];
        }

        $booking = Booking::create([
            'tour_id' => $validated['tour_id'],
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'nationality' => $validated['nationality'],
            'no_of_travellers' => $validated['no_of_travellers'],
            'accommodation_type_id' => $validated['accommodation_type_id'] ?? null,
            'selected_variants' => $selectedVariants,
            'total_price' => $validated['total_price'],
            'status' => 'pending',
        ]);

        $toEmail = trim((string) (Setting::get('email') ?? '')) ?: 'reservation@grandnilecruises.com';
        try {
            Mail::to($toEmail)->send(new BookingFormMail($booking, $tour));
        } catch (\Throwable $e) {
            Log::warning('Booking form email failed: ' . $e->getMessage(), ['exception' => $e]);
        }

        return redirect()->route('tours.show', $tour->slug)
            ->with('success', 'Your booking has been submitted successfully! We will contact you soon.');
    }
}
