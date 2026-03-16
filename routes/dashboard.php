<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\{
    HomeController,
    CategoryController,
    SubCategoryController,
    ProfileController as DashboardProfileController,
    UserController,
    RoleController,
    ContactController,
    SubscriberController,
    SliderController,
    TestimonialController,
    FaqController,
    CountryController,
    StateController,
    TourController,
    BlogController,
    BlogCategoryController,
    TourVariantController,
    GalleryController,
    CruiseExperienceController,
    CruiseGroupController,
    PageController,
    AnnouncementController,
    BookingController,
    SettingController,
    SiteSectionController,
};

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Categories Routes
    Route::resource('categories', CategoryController::class);

    // Sub Categories Routes
    Route::resource('sub-categories', SubCategoryController::class);

    // Profile Routes
    Route::get('/profile', [DashboardProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [DashboardProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [DashboardProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Users Routes
    Route::resource('users', UserController::class);

    // Roles Routes
    Route::resource('roles', RoleController::class);

    // Contacts Routes
    Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy']);
    Route::post('contacts/{id}/mark-read', [ContactController::class, 'markAsRead'])->name('contacts.mark-read');
    Route::post('contacts/{id}/mark-unread', [ContactController::class, 'markAsUnread'])->name('contacts.mark-unread');

    // Subscribers Routes
    Route::resource('subscribers', SubscriberController::class)->only(['index', 'destroy']);
    Route::patch('subscribers/{subscriber}/toggle-status', [SubscriberController::class, 'toggleStatus'])->name('subscribers.toggle-status');
    Route::get('subscribers/export', [SubscriberController::class, 'export'])->name('subscribers.export');

    // Galleries Routes
    Route::resource('galleries', GalleryController::class);

    // Sliders Routes
    Route::resource('sliders', SliderController::class);

    // Testimonials Routes
    Route::resource('testimonials', TestimonialController::class);

    // FAQs Routes
    Route::resource('faqs', FaqController::class);

    // Announcements Routes
    Route::resource('announcements', AnnouncementController::class);

    // Countries Routes
    Route::resource('countries', CountryController::class);

    // States Routes
    Route::resource('states', StateController::class);

    // Tours Routes
    Route::get('tours/get-states-by-country', [TourController::class, 'getStatesByCountry'])->name('tours.get-states-by-country');
    Route::get('tours/get-subcategories-by-category', [TourController::class, 'getSubCategoriesByCategory'])->name('tours.get-subcategories-by-category');
    Route::resource('tours', TourController::class);

    // Blogs Routes
    Route::resource('blogs', BlogController::class);

    // Blog Categories Routes
    Route::resource('blog-categories', BlogCategoryController::class)->except(['show']);

    // Site Sections Routes (homepage sections, about page sections, etc.)
    Route::get('site-sections/about', [SiteSectionController::class, 'about'])->name('site-sections.about');
    Route::resource('site-sections', SiteSectionController::class)->only(['index', 'edit', 'update']);

    // Cruise Groups Routes
    Route::resource('cruise-groups', CruiseGroupController::class);

    // Cruise Experiences Routes
    Route::resource('cruise-experiences', CruiseExperienceController::class);

    // Tour Variants Routes
    Route::resource('tour-variants', TourVariantController::class);

    // Pages Routes (only edit/update for SEO, no create/delete)
    Route::get('pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('pages/{page}', [PageController::class, 'update'])->name('pages.update');

    // Bookings Routes
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::put('bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    // Settings Routes
    Route::get('settings/edit', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
