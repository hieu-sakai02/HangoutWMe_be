<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ratingCoffeeShop extends Model
{
    protected $fillable = [
        'user_id',
        'coffee_shop_id',
        'comment',
        'rating',
        'show'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coffeeShop()
    {
        return $this->belongsTo(coffeeShop::class);
    }
}
