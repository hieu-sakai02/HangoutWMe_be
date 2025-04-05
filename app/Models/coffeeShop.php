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
        'pictures',
        'show'
    ];

    protected $appends = ['rating'];

    protected $casts = [
        'pictures' => 'array'
    ];

    public function ratings()
    {
        return $this->hasMany(ratingCoffeeShop::class, 'coffee_shop_id');
    }

    public function getRatingAttribute()
    {
        return $this->ratings()
            ->where('show', true)
            ->avg('rating') ?? 0;
    }
}
