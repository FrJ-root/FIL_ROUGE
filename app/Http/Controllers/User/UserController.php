<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;


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
        $messages = Auth::user()->messages()->latest()->get();
        return view('user.messages', compact('messages'));
    }

    /**
     * Display the admin profile.
     */
    public function showAdminProfile()
    {
        $user = Auth::user();
        return view('admin.pages.profile', compact('user'));
    }

    /**
     * Show the form for editing the admin profile.
     */
    public function editAdminProfile()
    {
        $user = Auth::user();
        return view('admin.pages.edit-profile', compact('user'));
    }

    /**
     * Update the admin profile.
     */
    public function updateAdminProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user = Auth::user();
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->hasFile('picture')) {
            // Delete old picture if it exists
            if ($user->picture) {
                Storage::disk('public')->delete($user->picture);
            }
            
            $path = $request->file('picture')->store('profile_pictures', 'public');
            $user->picture = $path;
        }
        
        $user->save();
        
        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
    }
}
