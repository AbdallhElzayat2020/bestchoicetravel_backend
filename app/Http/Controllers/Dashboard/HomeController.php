<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Blog;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Country;
use App\Models\CruiseExperience;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Role;
use App\Models\Slider;
use App\Models\State;
use App\Models\Subscriber;
use App\Models\Testimonial;
use App\Models\Tour;
use App\Models\TourVariant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get unread contacts count from cache (shared with sidebar)
        $unreadContactsCount = Cache::remember('unread_contacts_count', 300, function () {
            return Contact::where('is_read', false)->count();
        });

        // Load all cruise experiences once, then group them
        $allCruiseExperiences = CruiseExperience::query()
            ->latest()
            ->get();

        // Statistics - Optimized queries (removed sub_categories)
        $stats = [
            'totalCategories' => Category::count(),
            'activeCategories' => Category::where('status', 'active')->count(),
            'totalTours' => Tour::count(),
            'activeTours' => Tour::where('status', 'active')->count(),
            'totalTourVariants' => TourVariant::count(),
            'totalCruiseExperiences' => $allCruiseExperiences->count(),
            'activeCruiseExperiences' => $allCruiseExperiences->where('status', 'active')->count(),
            'totalCountries' => Country::count(),
            'totalStates' => State::count(),
            'totalBookings' => Booking::count(),
            'pendingBookings' => Booking::where('status', 'pending')->count(),
            'totalSliders' => Slider::count(),
            'activeSliders' => Slider::where('status', 'active')->count(),
            'totalBlogs' => Blog::count(),
            'activeBlogs' => Blog::where('status', 'active')->count(),
            'totalGalleries' => Gallery::count(),
            'activeGalleries' => Gallery::where('status', 'active')->count(),
            'totalTestimonials' => Testimonial::count(),
            'totalPages' => Page::count(),
            'totalAnnouncements' => Announcement::count(),
            'activeAnnouncements' => Announcement::where('status', 'active')->count(),
            'totalContacts' => Contact::count(),
            'unreadContacts' => $unreadContactsCount,
            'totalSubscribers' => Subscriber::count(),
            'totalUsers' => User::count(),
            'totalRoles' => Role::count(),
        ];

        // Recent items (last 3) - with eager loading (removed subCategories)
        $recent = [
            'categories' => Category::latest()->take(3)->get(),
            'tours' => Tour::with('category')->latest()->take(3)->get(),
            'blogs' => Blog::latest()->take(3)->get(),
        ];

        // Recent bookings (last 6) - with eager loading
        $recentBookings = Booking::with(['tour'])
            ->latest()
            ->take(6)
            ->get();

        // Recent cruise experiences by group (last 3 from each) - grouped from already loaded data
        $recentCruiseExperiences = [
            'dahabiya' => $allCruiseExperiences->where('group_key', 'dahabiya')->sortByDesc('created_at')->take(3)->values(),
            'ultra' => $allCruiseExperiences->where('group_key', 'ultra')->sortByDesc('created_at')->take(3)->values(),
            'grand' => $allCruiseExperiences->where('group_key', 'grand')->sortByDesc('created_at')->take(3)->values(),
        ];

        return view('dashboard.home.index', compact(
            'stats',
            'recent',
            'recentBookings',
            'recentCruiseExperiences'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
