<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\TravellerDashboardController;
use App\Http\Controllers\Admin\AccountValidationController;


Route::get('/', function () {
    return view('welcome');
});

// Trip
Route::get('/travel-guides', [TripController::class, 'index'])->name('travel-guides');

// Hotels
Route::get('/hotels', function () {
    return view('hotels.index');
})->name('hotels');

// switcher lang
Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr', 'ar'])) {
        session()->put('locale', $locale);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('set.locale');

// search
Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('login/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('login/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::get('login/facebook', [SocialAuthController::class, 'redirectToFacebook']);
Route::get('login/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

Route::middleware(['auth'])->group(function () {
    Route::get('/guide/dashboard', function () {
        return view('guide.guidedash');
    })->name('guide.dashboard');

    Route::get('/hotel/dashboard', function () {
        return view('hotel.dashboard');
    })->name('hotel.dashboard');

    Route::get('/transport/dashboard', function () {
        return view('transport.dashboard');
    })->name('transport.dashboard');

    Route::get('/traveller/dashboard', function () {
        return view('traveller.dashboard');
    })->name('traveller.dashboard');
});

// TravelCompany
Route::middleware(['auth', 'role:travel_company'])->prefix('company')->group(function () {
    Route::get('/dashboard', function () {
        return view('company.dashboard');
    })->name('company.dashboard');
});

// Hotel
Route::middleware(['auth', 'role:hotel'])->prefix('hotel')->group(function () {
    Route::get('/dashboard', function () {
        return view('hotel.dashboard');
    })->name('hotel.dashboard');
});

// Guide
Route::middleware(['auth', 'role:guide'])->prefix('guide')->group(function () {
    Route::get('/dashboard', function () {
        return view('guide.dashboard');
    })->name('guide.dashboard');
});

// Traveller
Route::prefix('traveller')->name('traveller.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('traveller.dashboard');
    })->name('dashboard');

    Route::get('/trips', function () {
        return view('traveller.pages.trips');
    })->name('trips');

    Route::get('/profile', [TravellerDashboardController::class, 'profile'])
    ->name('pages.profile');
    
    Route::get('/profile/edit', [TravellerDashboardController::class, 'editProfile'])
    ->name('profile.edit');
    
    Route::post('/profile/update', [TravellerDashboardController::class, 'updateProfile'])
    ->name('profile.update');

});

// Trip routes - Public and Protected
Route::get('/trips', [TripController::class, 'index'])->name('trips.index');

Route::middleware(['auth'])->group(function() {
    Route::get('/trips/create', [TripController::class, 'create'])->name('trips.create');
    Route::post('/trips', [TripController::class, 'store'])->name('trips.store');
});

// Then define wildcard/parameter routes
Route::get('/trips/{trip}', [TripController::class, 'show'])->name('trips.show');

// Protected Trip management routes (require authentication)
Route::middleware(['auth'])->group(function() {
    Route::get('/trips/{trip}/edit', [TripController::class, 'edit'])->name('trips.edit');
    Route::delete('/trips/{trip}/activities/{activity}', [TripController::class, 'removeActivity'])->name('trips.activities.remove');
    
    // Trip itinerary management
    Route::post('/trips/{trip}/itinerary', [TripController::class, 'updateItinerary'])->name('trips.itinerary.update');
    
    // Trip travellers management
    Route::post('/trips/{trip}/travellers', [TripController::class, 'addTraveller'])->name('trips.travellers.add');
    Route::delete('/trips/{trip}/travellers/{traveller}', [TripController::class, 'removeTraveller'])->name('trips.travellers.remove');
});

// Map routes - Fix the map route
Route::get('/maps', [MapController::class, 'index'])->name('maps.index');

// Destination routes
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destinations.show');

// User Profile & Settings
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('user.profile');
    })->name('user.profile');
    
    Route::get('/settings', function () {
        return view('user.settings');
    })->name('user.settings');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/home', function () {
        return view('admin.home');
    })->name('home'); 
    
    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard');
    })->name('dashboard');   
    
    Route::get('/categories', function () {
        return view('admin.pages.categories');
    })->name('categories');
    
    Route::get('/tags', function () {
        return view('admin.pages.tags');
    })->name('tags');
    
    Route::get('/courses', function () {
        return view('admin.pages.courses');
    })->name('courses');

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