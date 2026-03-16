<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    /**
     * Show the form for editing the settings.
     */
    public function edit()
    {
        // Get all settings in one query (cached)
        $settings = Setting::getAll();

        // Main menu name
        $mainCruisesMenuName = $settings['main_cruises_menu_name'] ?? 'Dahabiya & Cruises';

        $phone = $settings['phone'] ?? '+20 101 515 7744 / +20 101 515 7746';
        $email = $settings['email'] ?? 'info@grandnilecruises.com';
        $address = $settings['address'] ?? 'Sarayah Zayed 2 Building, Apartment 1,<br>8th District<br>Sheikh Zayed City - Giza';
        $navbarLogo = $settings['navbar_logo'] ?? null;
        $footerLogo = $settings['footer_logo'] ?? null;

        return view('dashboard.settings.edit', compact(
            'mainCruisesMenuName',
            'phone',
            'email',
            'address',
            'navbarLogo',
            'footerLogo'
        ));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'main_cruises_menu_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'navbar_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handle navbar logo upload
        if ($request->hasFile('navbar_logo')) {
            $logo = $request->file('navbar_logo');
            $logoName = time() . '_navbar_' . uniqid() . '.' . $logo->getClientOriginalExtension();
            $logoPath = $logo->storeAs('', $logoName, 'settings');

            // Delete old logo if exists
            $settings = Setting::getAll();
            $oldLogo = $settings['navbar_logo'] ?? null;
            if ($oldLogo && Storage::disk('settings')->exists($oldLogo)) {
                Storage::disk('settings')->delete($oldLogo);
            }

            Setting::set('navbar_logo', $logoPath);
        }

        // Handle footer logo upload
        if ($request->hasFile('footer_logo')) {
            $logo = $request->file('footer_logo');
            $logoName = time() . '_footer_' . uniqid() . '.' . $logo->getClientOriginalExtension();
            $logoPath = $logo->storeAs('', $logoName, 'settings');

            // Delete old logo if exists
            $settings = Setting::getAll();
            $oldLogo = $settings['footer_logo'] ?? null;
            if ($oldLogo && Storage::disk('settings')->exists($oldLogo)) {
                Storage::disk('settings')->delete($oldLogo);
            }

            Setting::set('footer_logo', $logoPath);
        }

        // Save cruise groups settings
        Setting::set('main_cruises_menu_name', $validated['main_cruises_menu_name']);

        Setting::set('phone', $validated['phone']);
        Setting::set('email', $validated['email']);
        Setting::set('address', $validated['address']);

        // Clear route cache
        Artisan::call('route:clear');
        Artisan::call('route:cache');

        return redirect()->back()
            ->with('success', 'Settings updated successfully');
    }
}
