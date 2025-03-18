<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'transport_type',
        'license_number',
        'address',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}