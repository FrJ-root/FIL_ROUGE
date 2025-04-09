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
        'description',
        'image',
        'location',
        'is_featured',
        'meta_title',
        'meta_description'
    ];

    public function travelGuides()
    {
        return $this->hasMany(TravelGuide::class);
    }
}
