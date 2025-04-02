<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class coffeeShop extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'houseNumber',
        'street',
        'ward',
        'district',
        'city',
        'phone',
        'email',
        'website',
        'thumbnail',
        'description',
        'show'
    ];
}
