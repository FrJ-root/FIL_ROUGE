<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traveller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trip_id',
        'itinerary_id',
        'nationality',
        'passport_number',
        'prefered_destination',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
    
    // Add this method to support the one-to-many relationship
    public function trips()
    {
        // For backwards compatibility, if used elsewhere
        if ($this->trip_id) {
            return Trip::where('id', $this->trip_id);
        }
        return Trip::whereNull('id');
    }

    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }
}