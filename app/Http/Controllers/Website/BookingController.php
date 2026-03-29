<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\BookingFormMail;
use App\Models\Booking;
use App\Models\Setting;
use App\Models\Tour;
use App\Models\TourSeasonalPriceItem;
use App\Services\RecaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

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
            if (! $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip())) {
                return redirect()->back()
                    ->withInput($request->except('g-recaptcha-response'))
                    ->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed. Please try again.']);
            }
        }

        $tour = Tour::query()
            ->with([
                'variants' => function ($q) {
                    $q->where('tour_variants.status', 'active')->orderBy('sort_order');
                },
                'seasonalPrices' => function ($q) {
                    $q->where('status', 'active')->with('priceItems');
                },
            ])
            ->findOrFail($validated['tour_id']);

        // Ensure selected_variants is an array
        $selectedVariants = $validated['selected_variants'] ?? [];
        if (! is_array($selectedVariants)) {
            $selectedVariants = [];
        }

        $this->assertBookingTotalMatchesTour($tour, $validated, $selectedVariants);

        $selectedVariants = array_values(array_unique(array_map('intval', $selectedVariants)));

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
            Log::warning('Booking form email failed: '.$e->getMessage(), ['exception' => $e]);
        }

        return redirect()->route('tours.show', $tour->slug)
            ->with('success', 'Your booking has been submitted successfully! We will contact you soon.');
    }

    /**
     * Recalculate expected total from server-side tour data and compare to submitted total_price.
     *
     * @param  array<int|string>  $selectedVariantIds
     */
    private function assertBookingTotalMatchesTour(Tour $tour, array $validated, array $selectedVariantIds): void
    {
        $base = (float) ($tour->current_price ?? $tour->price ?? 0);
        $perPerson = $base;

        $allowedVariantIds = $tour->variants->pluck('id')->map(fn ($id) => (int) $id)->all();
        $uniqueVariantIds = array_values(array_unique(array_filter(
            array_map('intval', $selectedVariantIds),
            fn (int $id) => $id > 0
        )));
        foreach ($uniqueVariantIds as $id) {
            if (! in_array($id, $allowedVariantIds, true)) {
                throw ValidationException::withMessages([
                    'selected_variants' => ['One or more selected options are not valid for this tour.'],
                ]);
            }
            $variant = $tour->variants->firstWhere('id', $id);
            $perPerson += (float) ($variant->additional_price ?? 0);
        }

        if (! empty($validated['accommodation_type_id'])) {
            $accId = (int) $validated['accommodation_type_id'];
            $validItemIds = $tour->seasonalPrices
                ->flatMap(fn ($sp) => $sp->priceItems->pluck('id'))
                ->map(fn ($id) => (int) $id)
                ->all();
            if (! in_array($accId, $validItemIds, true)) {
                throw ValidationException::withMessages([
                    'accommodation_type_id' => ['The selected accommodation is not valid for this tour.'],
                ]);
            }
            $item = TourSeasonalPriceItem::query()->find($accId);
            if ($item) {
                $perPerson += (float) ($item->price_value ?? 0);
            }
        }

        $travellers = (int) $validated['no_of_travellers'];
        $expected = round($perPerson * $travellers, 2);
        $submitted = round((float) $validated['total_price'], 2);

        if (abs($expected - $submitted) > 0.02) {
            throw ValidationException::withMessages([
                'total_price' => ['Price could not be verified. Please refresh the page and try again.'],
            ]);
        }
    }
}
