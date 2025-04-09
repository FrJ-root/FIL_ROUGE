<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'country',
        'star_rating',
        'price_per_night',
        'image',
        'amenities',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'amenities' => 'array',
        'star_rating' => 'float'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
