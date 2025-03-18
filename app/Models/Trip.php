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
    ];

    public function travellers()
    {
        return $this->hasMany(Traveller::class);
    }

    public function itinerary()
    {
        return $this->hasOne(Itinerary::class);
    }
}