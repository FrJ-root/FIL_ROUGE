<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'traveller_id',
        'guide_id',
        'hotel_id',
        'comment',
        'rating',
    ];

    public function travellers()
    {
        return $this->belongsTo(Traveller::class);
    }

    public function guides()
    {
        return $this->belongsTo(Guide::class);
    }
    
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
