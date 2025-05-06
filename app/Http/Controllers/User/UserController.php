<?php

namespace App\Http\Controllers\User;

use App\Repositories\Interfaces\GuideRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;
    protected $guideRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        GuideRepositoryInterface $guideRepository
    ) {
        $this->userRepository = $userRepository;
        $this->guideRepository = $guideRepository;
    }
    
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
        $this->userRepository->update($user->id, $request->only('name', 'email'));

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
        $this->guideRepository->updateAvailability($user->guide->id, $request->availability);

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

    public function showAdminProfile()
    {
        $user = Auth::user();
        return view('admin.pages.profile', compact('user'));
    }

    public function editAdminProfile()
    {
        $user = Auth::user();
        return view('admin.pages.edit-profile', compact('user'));
    }

    public function updateAdminProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        
        if ($request->hasFile('picture')) {
            $user = Auth::user();
            if ($user->picture) {
                Storage::disk('public')->delete($user->picture);
            }
            
            $path = $request->file('picture')->store('profile_pictures', 'public');
            $data['picture'] = $path;
        }
        
        $this->userRepository->update(Auth::id(), $data);
        
        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
    }
}
