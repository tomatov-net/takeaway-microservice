<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryTime extends Model
{
    protected $fillable = [
        'restaurant_id',
        'delivery_time', //in minutes
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }
}
