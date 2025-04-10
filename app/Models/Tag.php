<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_description'
    ];

    /**
     * The travel guides that belong to this tag.
     */
    public function travelGuides()
    {
        return $this->belongsToMany(TravelGuide::class, 'travel_guide_tag');
    }

    /**
     * The trips that belong to this tag.
     */
    public function trips()
    {
        return $this->belongsToMany(Trip::class, 'trip_tag');
    }
}
