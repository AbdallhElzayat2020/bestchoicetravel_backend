<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\TripPlannerMail;
use App\Models\Setting;
use App\Models\TripPlanner;
use App\Services\RecaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TripPlannerController extends Controller
{
    public function index()
    {
        $recaptchaSiteKey = config('services.recaptcha.site_key');

        return view('frontend.pages.trip-planner', compact('recaptchaSiteKey'));
    }

    public function store(Request $request, RecaptchaService $recaptcha)
    {
        $rules = [
            'full_name' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'phone' => 'nullable|string|max:40',
            'email' => 'required|email|max:255',
            'adults' => 'required|integer|min:1|max:50',
            'children' => 'required|integer|min:0|max:50',
            'infants' => 'required|integer|min:0|max:50',
            'arrival_date' => 'nullable|date',
            'departure_date' => 'nullable|date',
            'message' => 'required|string|max:10000',
        ];

        $validated = $request->validate($rules);

        if (! empty($validated['arrival_date']) && ! empty($validated['departure_date'])) {
            if ($validated['departure_date'] < $validated['arrival_date']) {
                return redirect()->back()
                    ->withErrors(['departure_date' => 'Departure date must be on or after arrival date.'])
                    ->withInput();
            }
        }

        // Do not block legitimate requests when captcha token is missing/expired.
        // If token exists, we still verify it.
        if (RecaptchaService::isConfigured() && $request->filled('g-recaptcha-response')) {
            if (! $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip())) {
                return redirect()->back()
                    ->withInput($request->except('g-recaptcha-response'))
                    ->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed. Please try again.']);
            }
        }

        $tripPlanner = TripPlanner::create([
            'full_name' => $validated['full_name'],
            'nationality' => $validated['nationality'],
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'],
            'adults' => $validated['adults'],
            'children' => $validated['children'],
            'infants' => $validated['infants'],
            'arrival_date' => $validated['arrival_date'] ?? null,
            'departure_date' => $validated['departure_date'] ?? null,
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        $toEmail = trim((string) (Setting::get('email') ?? '')) ?: 'reservation@grandnilecruises.com';
        try {
            Mail::to($toEmail)->send(new TripPlannerMail($tripPlanner));
        } catch (\Throwable $e) {
            Log::warning('Trip planner email failed: '.$e->getMessage(), ['exception' => $e]);
        }

        return redirect()->back()->with('success', 'Thank you! Your trip request has been received. We will contact you shortly.');
    }
}
