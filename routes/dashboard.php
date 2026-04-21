<?php

use App\Http\Controllers\Dashboard\AnnouncementController;
use App\Http\Controllers\Dashboard\BlogCategoryController;
use App\Http\Controllers\Dashboard\BlogController;
use App\Http\Controllers\Dashboard\BookingController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ContactController;
use App\Http\Controllers\Dashboard\CruiseVesselEnquiryController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\CruiseCatalogCategoryController;
use App\Http\Controllers\Dashboard\CruiseCatalogProgramController;
use App\Http\Controllers\Dashboard\CruiseCatalogVesselController;
use App\Http\Controllers\Dashboard\CruiseExperienceController;
use App\Http\Controllers\Dashboard\CruiseGroupController;
use App\Http\Controllers\Dashboard\FaqController;
use App\Http\Controllers\Dashboard\GalleryController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\PageController;
use App\Http\Controllers\Dashboard\ProfileController as DashboardProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\SiteSectionController;
use App\Http\Controllers\Dashboard\SliderController;
use App\Http\Controllers\Dashboard\StateController;
use App\Http\Controllers\Dashboard\SubCategoryController;
use App\Http\Controllers\Dashboard\SubscriberController;
use App\Http\Controllers\Dashboard\TripPlannerController;
use App\Http\Controllers\Dashboard\TestimonialController;
use App\Http\Controllers\Dashboard\TourController;
use App\Http\Controllers\Dashboard\TourVariantController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'dashboard.access'])->group(function () {

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Categories Routes
    Route::resource('categories', CategoryController::class)->middleware('permission.access:categories.manage');

    // Sub Categories Routes
    Route::resource('sub-categories', SubCategoryController::class)->middleware('permission.access:sub-categories.manage');

    // Profile Routes
    Route::get('/profile', [DashboardProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [DashboardProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [DashboardProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Users Routes
    Route::resource('users', UserController::class)->middleware('permission.access:users.manage');

    // Roles Routes
    Route::resource('roles', RoleController::class)->middleware('permission.access:roles.manage');

    // Contacts Routes
    Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy']);
    Route::post('contacts/{id}/mark-read', [ContactController::class, 'markAsRead'])->name('contacts.mark-read');
    Route::post('contacts/{id}/mark-unread', [ContactController::class, 'markAsUnread'])->name('contacts.mark-unread');

    // Trip Planner requests
    Route::get('trip-planners/export', [TripPlannerController::class, 'export'])->middleware('permission.access:trip-planners.manage')->name('trip-planners.export');
    Route::resource('trip-planners', TripPlannerController::class)->only(['index', 'show', 'destroy'])->middleware('permission.access:trip-planners.manage');
    Route::post('trip-planners/{tripPlanner}/mark-read', [TripPlannerController::class, 'markAsRead'])
        ->middleware('permission.access:trip-planners.manage')
        ->name('trip-planners.mark-read');
    Route::post('trip-planners/{tripPlanner}/mark-unread', [TripPlannerController::class, 'markAsUnread'])
        ->middleware('permission.access:trip-planners.manage')
        ->name('trip-planners.mark-unread');

    // Subscribers Routes
    Route::resource('subscribers', SubscriberController::class)->only(['index', 'destroy']);
    Route::patch('subscribers/{subscriber}/toggle-status', [SubscriberController::class, 'toggleStatus'])->name('subscribers.toggle-status');
    Route::get('subscribers/export', [SubscriberController::class, 'export'])->name('subscribers.export');

    // Galleries Routes
    Route::resource('galleries', GalleryController::class);

    // Sliders Routes
    Route::resource('sliders', SliderController::class);

    // Testimonials Routes
    Route::resource('testimonials', TestimonialController::class)->middleware('permission.access:testimonials.manage');

    // FAQs Routes
    Route::resource('faqs', FaqController::class)->middleware('permission.access:faqs.manage');

    // Announcements Routes
    Route::post('announcements/toggle-bar', [AnnouncementController::class, 'toggleBar'])
        ->middleware('permission.access:announcements.manage')
        ->name('announcements.toggle-bar');
    Route::resource('announcements', AnnouncementController::class)->middleware('permission.access:announcements.manage');

    // Countries Routes
    Route::resource('countries', CountryController::class)->middleware('permission.access:countries.manage');

    // States Routes
    Route::resource('states', StateController::class)->middleware('permission.access:states.manage');

    // Tours Routes
    Route::get('tours/get-states-by-country', [TourController::class, 'getStatesByCountry'])->middleware('permission.access:tours.manage')->name('tours.get-states-by-country');
    Route::get('tours/get-subcategories-by-category', [TourController::class, 'getSubCategoriesByCategory'])->middleware('permission.access:tours.manage')->name('tours.get-subcategories-by-category');
    Route::resource('tours', TourController::class)->middleware('permission.access:tours.manage');

    // Blogs Routes
    Route::resource('blogs', BlogController::class)->middleware('permission.access:blogs.manage');

    // Blog Categories Routes
    Route::resource('blog-categories', BlogCategoryController::class)->except(['show'])->middleware('permission.access:blog-categories.manage|blogs.manage');

    // Site Sections Routes (homepage sections, about page sections, etc.)
    Route::get('site-sections/about', [SiteSectionController::class, 'about'])->middleware('permission.access:site-sections.manage|site-sections.index')->name('site-sections.about');
    Route::resource('site-sections', SiteSectionController::class)->only(['index', 'edit', 'update'])->middleware('permission.access:site-sections.manage|site-sections.index');

    // Cruise Groups Routes
    Route::resource('cruise-groups', CruiseGroupController::class)->middleware('permission.access:cruise-groups.manage');

    // Cruise Experiences Routes
    Route::resource('cruise-experiences', CruiseExperienceController::class)->middleware('permission.access:sub-categories.manage');

    // Cruise catalog (categories → programs w/ days → vessels w/ 3 prices + gallery)
    Route::prefix('cruise-catalog')->name('cruise-catalog.')->group(function () {
        Route::resource('categories', CruiseCatalogCategoryController::class)
            ->parameters(['categories' => 'cruise_catalog_category'])
            ->except(['show'])
            ->middleware('permission.access:cruise-catalog.categories.manage|cruise-catalog.manage');
        Route::resource('programs', CruiseCatalogProgramController::class)->except(['show'])->middleware('permission.access:cruise-catalog.programs.manage|cruise-catalog.manage');
        Route::delete('vessels/{vessel}/cover', [CruiseCatalogVesselController::class, 'destroyCover'])
            ->middleware('permission.access:cruise-catalog.vessels.manage|cruise-catalog.manage')
            ->name('vessels.cover.destroy');
        Route::delete('vessels/{vessel}/gallery/{vesselImage}', [CruiseCatalogVesselController::class, 'destroyGalleryImage'])
            ->middleware('permission.access:cruise-catalog.vessels.manage|cruise-catalog.manage')
            ->name('vessels.gallery.destroy');
        Route::resource('vessels', CruiseCatalogVesselController::class)->except(['show'])->middleware('permission.access:cruise-catalog.vessels.manage|cruise-catalog.manage');
    });

    // Tour Variants Routes
    Route::resource('tour-variants', TourVariantController::class)->middleware('permission.access:tour-variants.manage');

    // Pages Routes (only edit/update for SEO, no create/delete)
    Route::get('pages', [PageController::class, 'index'])->middleware('permission.access:pages.manage')->name('pages.index');
    Route::get('pages/{page}/edit', [PageController::class, 'edit'])->middleware('permission.access:pages.manage')->name('pages.edit');
    Route::put('pages/{page}', [PageController::class, 'update'])->middleware('permission.access:pages.manage')->name('pages.update');

    // Bookings Routes (cruise-vessel enquiries must be registered before bookings/{booking})
    Route::get('bookings/cruise-vessels', [CruiseVesselEnquiryController::class, 'index'])
        ->middleware('permission.access:bookings.cruise-vessels.manage')
        ->name('bookings.cruise-vessels.index');
    Route::get('bookings/cruise-vessels/export', [CruiseVesselEnquiryController::class, 'export'])
        ->middleware('permission.access:bookings.cruise-vessels.manage')
        ->name('bookings.cruise-vessels.export');
    Route::get('bookings/cruise-vessels/{contact}', [CruiseVesselEnquiryController::class, 'show'])
        ->middleware('permission.access:bookings.cruise-vessels.manage')
        ->name('bookings.cruise-vessels.show');
    Route::post('bookings/cruise-vessels/{contact}/mark-read', [CruiseVesselEnquiryController::class, 'markAsRead'])
        ->middleware('permission.access:bookings.cruise-vessels.manage')
        ->name('bookings.cruise-vessels.mark-read');
    Route::post('bookings/cruise-vessels/{contact}/mark-unread', [CruiseVesselEnquiryController::class, 'markAsUnread'])
        ->middleware('permission.access:bookings.cruise-vessels.manage')
        ->name('bookings.cruise-vessels.mark-unread');

    Route::get('bookings', [BookingController::class, 'index'])->middleware('permission.access:bookings.manage')->name('bookings.index');
    Route::get('bookings/export', [BookingController::class, 'export'])->middleware('permission.access:bookings.manage')->name('bookings.export');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->middleware('permission.access:bookings.manage')->name('bookings.show');
    Route::put('bookings/{booking}', [BookingController::class, 'update'])->middleware('permission.access:bookings.manage')->name('bookings.update');
    Route::delete('bookings/{booking}', [BookingController::class, 'destroy'])->middleware('permission.access:bookings.manage')->name('bookings.destroy');

    // Settings Routes
    Route::get('settings/edit', [SettingController::class, 'edit'])->middleware('permission.access:settings.manage')->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->middleware('permission.access:settings.manage')->name('settings.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
