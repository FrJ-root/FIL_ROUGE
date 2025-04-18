<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('user.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user = Auth::user();
        $user->update($request->only('name', 'email'));

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }

    public function showAvailability()
    {
        $user = Auth::user();
        return view('user.availability', compact('user'));
    }

    public function updateAvailability(Request $request)
    {
        $request->validate([
            'availability' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->guide->update(['availability' => $request->availability]);

        return redirect()->route('user.availability')->with('success', 'Availability updated successfully.');
    }

    public function showTravellers()
    {
        $travellers = Auth::user()->guide->trips()->with('travellers')->get();
        return view('user.travellers', compact('travellers'));
    }

    public function showMessages()
    {
        // Assuming a Message model exists
        $messages = Auth::user()->messages()->latest()->get();
        return view('user.messages', compact('messages'));
    }
}
