<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'image',
        'views',
        'content',
        'author_id',
        'description',
        'is_featured',
        'category_id',
        'destination_id',
    ];

    public function categorys()
    {
        return $this->belongsTo(Category::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function authors()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'travel_guide_tag');
    }
}
