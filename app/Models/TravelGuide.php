<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'image',
        'category_id',
        'destination_id',
        'author_id',
        'is_featured',
        'views'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * The tags that belong to this travel guide.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'travel_guide_tag');
    }
}
