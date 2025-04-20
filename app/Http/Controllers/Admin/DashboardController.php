<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'activeTravellers' => $this->countByStatus('traveller', 'active'),
            'suspendedTravellers' => $this->countByStatus('traveller', 'suspended'),
            'deletedTravellers' => $this->countByStatus('traveller', 'deleted'),
            
            'activeTransports' => $this->countByStatus('transport', 'active'),
            'suspendedTransports' => $this->countByStatus('transport', 'suspended'),
            'deletedTransports' => $this->countByStatus('transport', 'deleted'),
            
            'activeGuides' => $this->countByStatus('guide', 'active'),
            'suspendedGuides' => $this->countByStatus('guide', 'suspended'),
            'deletedGuides' => $this->countByStatus('guide', 'deleted'),
            
            'activeHotels' => $this->countByStatus('hotel', 'active'),
            'suspendedHotels' => $this->countByStatus('hotel', 'suspended'),
        ];        
        return view('admin.dashboard', $data);
    }

    private function countByStatus($role, $status)
    {
        $query = User::where('role', $role);
        if ($status === 'deleted') {
            return $query->onlyTrashed()->count();
        }
        return $query->where('status', $status)->count();
    }
}