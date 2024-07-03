<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeYourCar extends Model
{
    use HasFactory;

    protected $casts = [
        'current_car_photos' => 'array',
    ];
    
}
