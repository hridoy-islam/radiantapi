<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeYourCar extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'first_name', 'last_name', 'phone_number', 'email', 'current_car_brand', 'current_car_model', 'current_car_year', 'current_car_mileage', 'current_car_transmission_type', 'current_car_photos', 'current_car_special_notes', 'expected_car_model', 'expected_car_year', 'expected_car_mileage', 'expected_car_transmission_type', 'expected_car_special_notes'
    ];

    protected $casts = [
        'current_car_photos' => 'array',
    ];
    
}
