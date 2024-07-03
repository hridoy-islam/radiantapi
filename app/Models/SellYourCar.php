<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellYourCar extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname', 'lastname', 'phone', 'email', 'brand', 'model', 'year', 'mileage', 'transmissiontype', 'images', 'comment'
    ];

    protected $casts = [
        'images' => 'array', // Casts the images field to an array.
    ];
}
