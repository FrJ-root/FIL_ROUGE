<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traveller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nationality',
        'passport_number',
        'prefered_destination',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
