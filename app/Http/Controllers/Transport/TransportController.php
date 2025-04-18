<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function showProfile()
    {
        $transport = Auth::user()->transport;
        return view('transport.profile', compact('transport'));
    }

    public function showTrips()
    {
        $trips = Auth::user()->transport->trips()->with('guides', 'travellers')->get();
        return view('transport.trips', compact('trips'));
    }
}
