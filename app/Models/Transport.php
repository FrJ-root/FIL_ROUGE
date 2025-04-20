<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'user_id',
        'address',
        'company_name',
        'license_number',
        'transport_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function trips()
    {
        return $this->belongsToMany(Trip::class, 'trip_transport');
    }
}