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
use App\Models\Role;
use App\Models\State;
use App\Models\Subscriber;
use App\Models\Testimonial;
use App\Models\Tour;
use App\Models\TourVariant;
use App\Models\TripPlanner;
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
        $user = request()->user();

        if (! $user || (! $user->isAdmin() && ! $user->hasPermission('dashboard.access'))) {
            return redirect()->route('user.home');
        }

        $unreadContactsCount = Cache::remember('unread_contacts_count', 300, function () {
            return Contact::where('is_read', false)->count();
        });

        $allCruiseExperiences = CruiseExperience::query()
            ->latest()
            ->get();

        $totalCruiseBookings = Contact::query()->cruiseVesselEnquiries()->count();
        $unreadCruiseBookings = Contact::query()->cruiseVesselEnquiries()->where('is_read', false)->count();
        $totalTripPlannerLeads = TripPlanner::count();
        $unreadTripPlannerLeads = TripPlanner::where('is_read', false)->count();

        $stats = [
            'totalBookings' => Booking::count(),
            'pendingBookings' => Booking::where('status', 'pending')->count(),
            'confirmedBookings' => Booking::where('status', 'confirmed')->count(),
            'totalCruiseBookings' => $totalCruiseBookings,
            'unreadCruiseBookings' => $unreadCruiseBookings,
            'totalTripPlannerLeads' => $totalTripPlannerLeads,
            'unreadTripPlannerLeads' => $unreadTripPlannerLeads,
            'totalContacts' => Contact::count(),
            'unreadContacts' => $unreadContactsCount,
            'totalSubscribers' => Subscriber::count(),
            'totalCategories' => Category::count(),
            'activeCategories' => Category::where('status', 'active')->count(),
            'totalTours' => Tour::count(),
            'activeTours' => Tour::where('status', 'active')->count(),
            'totalTourVariants' => TourVariant::count(),
            'activeTourVariants' => TourVariant::where('status', 'active')->count(),
            'totalCruiseExperiences' => $allCruiseExperiences->count(),
            'activeCruiseExperiences' => $allCruiseExperiences->where('status', 'active')->count(),
            'totalBlogs' => Blog::count(),
            'activeBlogs' => Blog::where('status', 'active')->count(),
            'totalTestimonials' => Testimonial::count(),
            'totalAnnouncements' => Announcement::count(),
            'activeAnnouncements' => Announcement::where('status', 'active')->count(),
            'totalCountries' => Country::count(),
            'totalStates' => State::count(),
            'totalUsers' => User::count(),
            'totalRoles' => Role::count(),
        ];

        return view('dashboard.home.index', compact('stats'));
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
