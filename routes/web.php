<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialAuthController;

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
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

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