<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('login/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('login/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::get('login/facebook', [SocialAuthController::class, 'redirectToFacebook']);
Route::get('login/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);


Route::middleware(['auth'])->group(function () {
    Route::get('/guide/dashboard', function () {
        return view('guide.dashboard');
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


Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
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
    
    Route::get('/account-validation', function () {
        return view('admin.pages.account-validation');
    })->name('account-validation');
    
    Route::get('/settings', function () {
        return view('admin.pages.settings');
    })->name('settings');
    
    Route::get('/help', function () {
        return view('admin.pages.help');
    })->name('help');
});