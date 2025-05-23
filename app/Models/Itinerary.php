<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'trip_id',
        'description',
    ];

    public function travellers()
    {
        return $this->hasMany(Traveller::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
