<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Setting;
use App\Services\RecaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $page = Page::getBySlug('contact-us');
        $metaTitle = $page && $page->meta_title ? $page->meta_title : 'Contact Us';
        $recaptchaSiteKey = config('services.recaptcha.site_key');

        return view('frontend.pages.contact-us', compact('page', 'metaTitle', 'recaptchaSiteKey'));
    }

    public function store(Request $request, RecaptchaService $recaptcha)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
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

        Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        $toEmail = trim((string) (Setting::get('email') ?? '')) ?: 'reservation@grandnilecruises.com';
        try {
        Mail::to($toEmail)->send(new ContactFormMail(
            $validated['name'],
            $validated['email'],
            $validated['phone'] ?? null,
            $validated['subject'] ?? null,
            $validated['message']  // passed as contactMessage in Mailable
        ));
        } catch (\Throwable $e) {
            Log::warning('Contact form email failed: ' . $e->getMessage(), ['exception' => $e]);
        }

        return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
