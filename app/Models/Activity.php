<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'trip_id',
        'location',
        'description',
        'scheduled_at',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}