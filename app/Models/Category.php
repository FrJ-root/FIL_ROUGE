<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
        'image',
        'is_featured',
        'meta_title',
        'meta_description'
    ];

    /**
     * Get the travel guides in this category.
     */
    public function travelGuides()
    {
        return $this->hasMany(TravelGuide::class);
    }
}
