<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use App\Models\Contact;
use App\Models\CruiseCatalogCategory;
use App\Models\CruiseCatalogVessel;
use App\Models\Setting;
use App\Services\RecaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CruiseCatalogController extends Controller
{
    public function category(string $categorySlug)
    {
        $category = CruiseCatalogCategory::active()
            ->where('slug', $categorySlug)
            ->firstOrFail();

        $vessels = CruiseCatalogVessel::active()
            ->where('cruise_catalog_category_id', $category->id)
            ->with(['images'])
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(12);

        return view('frontend.pages.cruise-catalog.category', compact('category', 'vessels'));
    }

    public function vessel(string $categorySlug, string $vesselSlug)
    {
        $category = CruiseCatalogCategory::active()
            ->where('slug', $categorySlug)
            ->firstOrFail();

        $vessel = CruiseCatalogVessel::active()
            ->where('cruise_catalog_category_id', $category->id)
            ->where('slug', $vesselSlug)
            ->with([
                'category',
                'images',
                'programs' => function ($query) {
                    $query->with(['days'])->orderBy('sort_order')->orderBy('title');
                },
            ])
            ->firstOrFail();

        $relatedVessels = CruiseCatalogVessel::active()
            ->where('cruise_catalog_category_id', $category->id)
            ->where('id', '!=', $vessel->id)
            ->with(['images'])
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->take(6)
            ->get();

        $recaptchaSiteKey = config('services.recaptcha.site_key');

        return view('frontend.pages.cruise-catalog.vessel-details', compact('category', 'vessel', 'relatedVessels', 'recaptchaSiteKey'));
    }

    public function submitEnquiry(Request $request, string $categorySlug, string $vesselSlug, RecaptchaService $recaptcha)
    {
        $category = CruiseCatalogCategory::active()
            ->where('slug', $categorySlug)
            ->firstOrFail();

        $vessel = CruiseCatalogVessel::active()
            ->where('cruise_catalog_category_id', $category->id)
            ->where('slug', $vesselSlug)
            ->firstOrFail();

        $rules = [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'no_of_travellers' => 'required|integer|min:1',
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

        $subject = 'Cruise vessel enquiry: '.$vessel->title;
        $message = 'Cruise vessel enquiry'.PHP_EOL
            .'Vessel: '.$vessel->title.PHP_EOL
            .'Category: '.$category->name.PHP_EOL
            .'Travellers: '.$validated['no_of_travellers'].PHP_EOL
            .'Estimated total: $'.number_format((float) $validated['total_price'], 2);

        Contact::create([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $subject,
            'message' => $message,
            'is_read' => false,
        ]);

        $toEmail = trim((string) (Setting::get('email') ?? '')) ?: 'reservation@grandnilecruises.com';
        try {
            Mail::to($toEmail)->send(new ContactFormMail(
                $validated['full_name'],
                $validated['email'],
                $validated['phone'],
                $subject,
                $message
            ));
        } catch (\Throwable $e) {
            Log::warning('Cruise vessel enquiry email failed: '.$e->getMessage(), ['exception' => $e]);
        }

        return redirect()->route('cruise-catalog.vessel', [$category->slug, $vessel->slug])
            ->with('success', 'Your enquiry has been submitted successfully! We will contact you soon.');
    }
}
