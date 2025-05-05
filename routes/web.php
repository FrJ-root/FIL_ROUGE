<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Map\MapController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Guide\GuideController;
use \App\Http\Controllers\Hotel\HotelController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Search\SearchController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Activity\ActivityController;
use App\Http\Controllers\Itinerary\ItineraryController;
use App\Http\Controllers\Traveller\TravellerController;
use App\Http\Controllers\Transport\TransportController;
use App\Http\Controllers\Admin\AccountValidationController;
use App\Http\Controllers\Destination\DestinationController;


//  => welcome -------------------------------------
Route::get('/', function () {
    return view('welcome');
});

// => user ------------------------------------
Route::prefix('user')->name('user.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    Route::get('/profile', [UserController::class, 'showProfile'])
    ->name('profile');

    Route::get('/profile/edit', [UserController::class, 'editProfile'])
    ->name('profile.edit');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])
    ->name('profile.update');

    Route::get('/availability', [UserController::class, 'showAvailability'])
    ->name('availability');

    Route::post('/availability/update', [UserController::class, 'updateAvailability'])
    ->name('availability.update');

    Route::get('/travellers', [UserController::class, 'showTravellers'])
    ->name('travellers');
    
    Route::get('/messages', [UserController::class, 'showMessages'])
    ->name('messages');
});

// => admin -------------------------------------
Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function () {

    Route::get('/home', function () {
        return view('admin.home');
    })->name('home'); 
    
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');   
    
    Route::get('/profile', [UserController::class, 'showAdminProfile'])
    ->name('profile');

    Route::get('/profile/edit', [UserController::class, 'editAdminProfile'])
    ->name('profile.edit');

    Route::post('/profile/update', [UserController::class, 'updateAdminProfile'])
    ->name('profile.update');
    
    Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories');

    Route::post('/categories', [CategoryController::class, 'store'])
    ->name('categories.store');

    Route::put('/categories/{id}', [CategoryController::class, 'update'])
    ->name('categories.update');

    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])
    ->name('categories.destroy');
    
    Route::get('/tags', [TagController::class, 'index'])
    ->name('tags');

    Route::post('/tags', [TagController::class, 'store'])
    ->name('tags.store');

    Route::put('/tags/{id}', [TagController::class, 'update'])
    ->name('tags.update');

    Route::delete('/tags/{id}', [TagController::class, 'destroy'])
    ->name('tags.destroy');
    
    Route::get('/trips', [DashboardController::class, 'trips'])
    ->name('trips');

    Route::post('/trips/{id}/assign', [DashboardController::class, 'assignTrip'])
    ->name('trips.assign');

    Route::post('/trips/{id}/status', [DashboardController::class, 'updateTripStatus'])
    ->name('trips.status');

    Route::delete('/trips/{id}', [DashboardController::class, 'destroyTrip'])
    ->name('trips.destroy');
    
    Route::get('/account-validation', [AccountValidationController::class, 'index'])
    ->name('account-validation');

    Route::post('/account-validation/{user}', [AccountValidationController::class, 'updateStatus'])
    ->name('account-validation.update');

    Route::get('/settings', function () {
        return view('admin.pages.settings');
    })->name('settings');
    
    Route::get('/help', function () {
        return view('admin.pages.help');
    })->name('help');

});

// => Manager -------------------------------------
Route::prefix('manager')->name('manager.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [ManagerController::class, 'dashboard'])
    ->name('dashboard');
    
    Route::get('/profile', [ManagerController::class, 'profile'])
    ->name('profile');

    Route::get('/profile/edit', [ManagerController::class, 'editProfile'])
    ->name('profile.edit');

    Route::post('/profile/update', [ManagerController::class, 'updateProfile'])
    ->name('profile.update');
    
    Route::get('/profile/password', [ManagerController::class, 'editPassword'])
    ->name('profile.password');

    Route::post('/profile/password/update', [ManagerController::class, 'updatePassword'])
    ->name('profile.password.update');
    
    Route::get('/collaborators', [ManagerController::class, 'collaborators'])
    ->name('collaborators');
    
    Route::get('/travellers', [ManagerController::class, 'travellers'])
    ->name('travellers');

    Route::get('/travellers/{id}', [ManagerController::class, 'viewTraveller'])
    ->name('travellers.view');

    Route::post('/travellers/{id}/cancel-trip', [ManagerController::class, 'cancelTravellerTrip'])
    ->name('travellers.cancel-trip');

    Route::post('/travellers/{id}/confirm-payment', [ManagerController::class, 'confirmTravellerPayment'])
    ->name('travellers.confirm-payment');
    
    Route::get('/trips', [ManagerController::class, 'trips'])
    ->name('trips');

    Route::get('/trips/create', [ManagerController::class, 'create'])
    ->name('trips.create');

    Route::post('/trips', [ManagerController::class, 'store'])
    ->name('trips.store');

    Route::get('/trips/{id}', [ManagerController::class, 'show'])
    ->name('trips.show');

    Route::get('/trips/{id}/edit', [ManagerController::class, 'edit'])
    ->name('trips.edit');

    Route::put('/trips/{id}', [ManagerController::class, 'update'])
    ->name('trips.update');

    Route::delete('/trips/{id}', [ManagerController::class, 'destroy'])
    ->name('trips.destroy');
    
    Route::get('/trips/{id}/collaborations', [ManagerController::class, 'manageCollaborations'])
    ->name('collaborations');

    Route::post('/trips/{id}/collaborators', [ManagerController::class, 'addCollaborator'])
    ->name('collaborators.add');

    Route::delete('/trips/{id}/collaborators', [ManagerController::class, 'removeCollaborator'])
    ->name('collaborators.remove');
    
    Route::get('/collaborator-trips/{type}', [ManagerController::class, 'collaboratorTrips'])
    ->name('collaborator.trips');
});

// => Traveller --------------------------------------
Route::prefix('traveller')->name('traveller.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('traveller.dashboard');
    })->name('dashboard');

    Route::get('/trips', [TravellerController::class, 'trips'])
    ->name('trips');
    
    Route::get('/profile', [TravellerController::class, 'profile'])
    ->name('pages.profile');
    
    Route::get('/profile/edit', [TravellerController::class, 'editProfile'])
    ->name('profile.edit');
    
    Route::post('/profile/update', [TravellerController::class, 'updateProfile'])
    ->name('profile.update');
    
    Route::get('/settings', function () {
        return view('traveller.pages.settings');
    })->name('settings');
    
    Route::post('/trips/add/{trip}', [TravellerController::class, 'addTrip'])
    ->name('trips.add');

    Route::post('/trips/remove/{trip}', [TravellerController::class, 'removeTrip'])
    ->name('trips.remove');
    
    Route::get('/trips/{trip}/payment', [TravellerController::class, 'showPayment'])
    ->name('trips.payment');

    Route::post('/trips/{trip}/payment', [TravellerController::class, 'processPayment'])
    ->name('trips.process-payment');
    
    Route::get('/check-payment', [TravellerController::class, 'checkPaymentRequired'])
    ->name('check-payment');

});

// => Guide --------------------------------------
Route::prefix('guide')->name('guide.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('guide.dashboard');
    })->name('dashboard');

    Route::get('/trips', function () {
        return view('guide.pages.trips');
    })->name('trips');

    Route::get('/available-trips', [GuideController::class, 'availableTrips'])
        ->name('available-trips');

    Route::get('/trips/{id}', [GuideController::class, 'showTripDetails'])
        ->name('trip.details');

    Route::post('/withdraw-trip/{id}', [GuideController::class, 'withdrawFromTrip'])
        ->name('withdraw-trip');

    Route::post('/join-trip', [GuideController::class, 'joinTrip'])
        ->name('join-trip');

    Route::get('/availability', [GuideController::class, 'showAvailability'])
    ->name('availability');

    Route::post('/availability', [GuideController::class, 'updateAvailability'])
    ->name('availability.update');

    Route::get('/profile', [GuideController::class, 'showProfile'])
    ->name('profile');

    Route::get('/profile/edit', [GuideController::class, 'editProfile'])
    ->name('profile.edit');

    Route::post('/profile/update', [GuideController::class, 'updateProfile'])
    ->name('profile.update');

    Route::get('/travellers', [GuideController::class, 'showTravellers'])
    ->name('travellers');

    Route::post('/travellers/message', [GuideController::class, 'sendMessageToTraveller'])
    ->name('travellers.message');

    Route::get('/messages', [GuideController::class, 'showMessages'])
    ->name('messages');

    Route::get('/reviews', [GuideController::class, 'showReviews'])
    ->name('reviews');

    Route::get('/guide/availability', [GuideController::class, 'showAvailability'])
    ->name('guide.availability');
    
    Route::post('/reviews', [GuideController::class, 'storeReview'])
    ->name('reviews.store');
});

// => Hotel --------------------------------------
Route::middleware(['auth'])->prefix('hotel')->name('hotel.')->group(function () {

    Route::get('/dashboard', [HotelController::class, 'dashboard'])
    ->name('dashboard');
    
    Route::get('/profile', [HotelController::class, 'showProfile'])
    ->name('profile');

    Route::get('/profile/edit', [HotelController::class, 'editProfile'])
    ->name('profile.edit');

    Route::post('/profile/update', [HotelController::class, 'updateProfile'])
    ->name('profile.update');

    Route::get('/profile/create', [HotelController::class, 'createProfile'])
    ->name('profile.create');

    Route::post('/profile/store', [HotelController::class, 'storeProfile'])
    ->name('profile.store');
    
    Route::get('/rooms', [HotelController::class, 'showRooms'])
    ->name('rooms');

    Route::get('/rooms/create', [HotelController::class, 'createRoom'])
    ->name('rooms.create');

    Route::post('/rooms', [HotelController::class, 'storeRoom'])
    ->name('rooms.store');

    Route::get('/rooms/{room}/edit', [HotelController::class, 'editRoom'])
    ->name('rooms.edit');

    Route::put('/rooms/{room}', [HotelController::class, 'updateRoom'])
    ->name('rooms.update');

    Route::delete('/rooms/{room}', [HotelController::class, 'destroyRoom'])
    ->name('rooms.destroy');
    
    Route::get('/bookings', [HotelController::class, 'showBookings'])
    ->name('bookings');

    Route::get('/bookings/{booking}', [HotelController::class, 'showBookingDetails'])
    ->name('bookings.show');

    Route::post('/bookings/{booking}/confirm', [HotelController::class, 'confirmBooking'])
    ->name('bookings.confirm');

    Route::post('/bookings/{booking}/cancel', [HotelController::class, 'cancelBooking'])
    ->name('bookings.cancel');
    
    Route::get('/reviews', [HotelController::class, 'showReviews'])
    ->name('reviews');
    
    Route::get('/settings', [HotelController::class, 'showSettings'])
    ->name('settings');
    
    Route::get('/availability', [HotelController::class, 'showAvailability'])
    ->name('availability');
    
    Route::post('/availability/update', [HotelController::class, 'updateAvailability'])
    ->name('availability.update');
    
    Route::get('/trips', [HotelController::class, 'showTrips'])
    ->name('trips');

    Route::get('/trips/{id}', [HotelController::class, 'showTripDetails'])
    ->name('trip.details');

    Route::get('/available-trips', [HotelController::class, 'availableTrips'])
    ->name('available-trips');

    Route::post('/join-trip', [HotelController::class, 'joinTrip'])
    ->name('join-trip');

    Route::post('/withdraw-trip/{id}', [HotelController::class, 'withdrawFromTrip'])
    ->name('withdraw-trip');

});

Route::get('/hotels', function () {
    return view('hotels.index');
})->name('hotels');

// => Transport ----------------------------------------
Route::prefix('transport')->name('transport.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('transport.dashboard');
    })->name('dashboard');

    Route::get('/profile', [TransportController::class, 'showProfile'])
    ->name('profile');
    
    Route::get('/profile/edit', [TransportController::class, 'editProfile'])
    ->name('profile.edit');
    
    Route::post('/profile/update', [TransportController::class, 'updateProfile'])
    ->name('update-profile');

    Route::get('/trips', [TransportController::class, 'showTrips'])
    ->name('trips');
    
    Route::get('/trips/index', [TransportController::class, 'tripsIndex'])
    ->name('trips.index');

    Route::get('/trips/{id}', [TransportController::class, 'showTripDetails'])
    ->name('trip.details');
    
    Route::get('/available-trips', [TransportController::class, 'availableTrips'])
    ->name('available-trips');
    
    Route::post('/join-trip', [TransportController::class, 'joinTrip'])
    ->name('join-trip');
    
    Route::post('/withdraw-trip/{id}', [TransportController::class, 'withdrawFromTrip'])
    ->name('withdraw-trip');

    Route::get('/availability', [TransportController::class, 'showAvailability'])
    ->name('availability');
    
    Route::post('/availability/update', [TransportController::class, 'updateAvailability'])
    ->name('availability.update');

});

// => Profile & Settings --------------------------------------
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', function () {
        return view('user.profile');
    })->name('user.profile');
    
    Route::get('/settings', function () {
        return view('user.settings');
    })->name('user.settings');
});

// => Trip ------------------------------------
Route::middleware(['auth'])->group(function () {

    Route::get('/trips/create', [ManagerController::class, 'create'])
    ->name('trips.create');

    Route::post('/trips', [ManagerController::class, 'store'])
    ->name('trips.store');

    Route::get('/trips/{trip}/edit', [ManagerController::class, 'edit'])
    ->name('trips.edit');

    Route::put('/trips/{trip}', [ManagerController::class, 'update'])
    ->name('trips.update');

    Route::delete('/trips/{trip}', [ManagerController::class, 'destroy'])
    ->name('trips.destroy');
    
    Route::post('/trips/{trip}/activities', [ActivityController::class, 'store'])
    ->name('activities.store');

    Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])
    ->name('activities.destroy');
    
    Route::put('/trips/{trip}/itinerary', [ItineraryController::class, 'update'])
    ->name('itinerary.update');

});
Route::get('/travel-guides', [ManagerController::class, 'index'])->name('travel-guides');
Route::get('/trips', [ManagerController::class, 'index'])->name('trips.index');
Route::get('/trips/{trip}', [ManagerController::class, 'show'])->name('trips.show');

// => auth -----------------------------------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('login/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('login/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::get('login/facebook', [SocialAuthController::class, 'redirectToFacebook']);
Route::get('login/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// => profile -------------------------------------------
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'index'])
    ->name('profile.index');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])
    ->name('profile.edit');

    Route::post('/profile/update', [ProfileController::class, 'update'])
    ->name('profile.update');

});

// => langue -------------------------------------------
Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr', 'ar'])) {
        session()->put('locale', $locale);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('set.locale');

// => search ----------------------------------------
Route::get('/search', [SearchController::class, 'index'])->name('search');

// => Map -------------------------------------------
Route::get('/maps', [MapController::class, 'index'])->name('maps.index');

// => Destination --------------------------------------------
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destinations.show');