<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'name'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'restaurant_id');
    }

    public function delivery_time()
    {
        return $this->hasOne(DeliveryTime::class, 'restaurant_id');
    }
}
