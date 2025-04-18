<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_description'
    ];

    public function travelGuides(){
        return $this->belongsToMany(TravelGuide::class, 'travel_guide_tag');
    }

    public function trips(){
        return $this->belongsToMany(Trip::class, 'trip_tag');
    }
}
