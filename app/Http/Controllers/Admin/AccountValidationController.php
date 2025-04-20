<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AccountValidationController extends Controller
{
    public function index()
    {
        $travellers = User::whereHas('traveller')->with('traveller')->get();
        $transports = User::whereHas('transport')->with('transport')->get();
        $hotels = User::whereHas('hotel')->with('hotel')->get();
        $guides = User::whereHas('guide')->with('guide')->get();

        return view('admin.pages.account-validation', compact('travellers', 'transports', 'hotels', 'guides'));
    }

    public function updateStatus(Request $request, $id){
        $validated = $request->validate([
            'status' => 'required|in:valide,suspend,block',
        ]);
    
        $user = User::findOrFail($id);
        $user->status = $validated['status'];
        $user->save();
    
        $status = $validated['status'];
        $color = match($status) {
            'valide' => 'green',
            'suspend' => 'yellow',
            'block' => 'red',
            default => 'gray',
        };
    
        return back()->with([
            'success' => "Status updated to " . ucfirst($status),
            'status_color' => $color
        ]);
    }          
}