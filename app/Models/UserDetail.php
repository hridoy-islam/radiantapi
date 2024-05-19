<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'division', 'district', 'upazila', 'union', 'profile_picture'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
