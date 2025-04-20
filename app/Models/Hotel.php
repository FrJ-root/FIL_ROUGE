<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'image',
        'address',
        'country',
        'latitude',
        'longitude',
        'amenities',
        'description',
        'star_rating',
        'price_per_night',
        'availability',
        'selected_dates',
        'available_rooms',
        'user_id',
    ];

    protected $casts = [
        'amenities' => 'array',
        'star_rating' => 'float',
        'availability' => 'string',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function trips()
    {
        return $this->belongsToMany(Trip::class, 'trip_hotel');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
