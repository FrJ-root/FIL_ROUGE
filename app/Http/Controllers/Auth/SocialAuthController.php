<?php
namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\str;
use App\Models\User;
use Exception;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = $this->findOrCreateUser($googleUser, 'google');
            Auth::login($user);

            return redirect()->route('home');
        } catch (Exception $e) {
            return redirect('/login');
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            $user = $this->findOrCreateUser($facebookUser, 'facebook');
            Auth::login($user);

            return redirect()->route('home');
        } catch (Exception $e) {
            return redirect('/login');
        }
    }

    private function findOrCreateUser($socialUser, $provider)
    {
        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(str::random(16)),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ]);
        }

        return $user;
    }
}