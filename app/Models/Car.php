<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'exterior_colour', 'interior_colour', 'body_style', 'transmission',
        'stock', 'vin', 'km', 'engine', 'fuel_efficiency', 'drivetrain', 'price',
        'year', 'cartype', 'overview', 'exterior', 'interior', 'entertainment',
        'mechanical', 'safety', 'techspecs', 'bluetooth', 'cruiseControl',
        'smartphoneIntegration', 'backupCamera', 'multizoneAC', 'rearAC',
        'keylessEntry', 'antiLockBrakes', 'powerSeats', 'thirdRowSeating',
        'heatedSeats', 'remoteStart', 'keyLessStart', 'streeingwheelcontrol'
    ];

    

    
}
