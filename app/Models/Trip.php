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
        'manager_id',
        'status',
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
    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'trip_category');
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'trip_tag');
    }
    
    public function transports()
    {
        return $this->belongsToMany(Transport::class, 'trip_transport');
    }
    
    public function guides()
    {
        return $this->belongsToMany(Guide::class, 'trip_guide');
    }
    
    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'trip_hotel');
    }
    
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}