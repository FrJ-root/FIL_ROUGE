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
        'rating',
        'comment',
    ];

    public function traveller()
    {
        return $this->belongsTo(Traveller::class);
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }
}
