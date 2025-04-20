<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'location',
        'meta_title',
        'is_featured',
        'description',
        'meta_description',
    ];

    public function travelGuides()
    {
        return $this->hasMany(TravelGuide::class);
    }
}
