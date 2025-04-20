<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'availability', 
        'license_number', 
        'selected_dates',
        'specialization',
        'preferred_locations', 
    ];

    protected $casts = [
        'availability' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trips()
    {
        return $this->belongsToMany(Trip::class, 'trip_guide');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}