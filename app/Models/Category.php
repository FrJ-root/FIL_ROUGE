<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'meta_title',
        'description',
        'is_featured',
        'meta_description',
    ];

    public function travelGuides(){
        return $this->hasMany(TravelGuide::class);
    }

    public function trips(){
        return $this->belongsToMany(Trip::class, 'trip_category');
    }
}