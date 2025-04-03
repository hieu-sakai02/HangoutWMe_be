<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class favCoffeeShop extends Model
{
    protected $fillable = [
        'user_id',
        'coffee_shop_id',
        'is_favorite'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with CoffeeShop
    public function coffeeShop()
    {
        return $this->belongsTo(coffeeShop::class);
    }
}
