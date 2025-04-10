<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination',
        'start_date',
        'end_date',
        'cover_picture',
    ];

    public function travellers()
    {
        return $this->hasMany(Traveller::class);
    }

    public function itinerary()
    {
        return $this->hasOne(Itinerary::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    
    // New relationships for trip filtering
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'trip_category');
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'trip_tag');
    }
    
    public function transportCompanies()
    {
        return $this->belongsToMany(TransportCompany::class, 'trip_transport_company');
    }
    
    public function guides()
    {
        return $this->belongsToMany(Guide::class, 'trip_guide');
    }
    
    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'trip_hotel');
    }
}