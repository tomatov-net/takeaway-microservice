<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $dates = [
        'delivered_at',
        'deliver_before',
    ];

    protected $fillable = [
        'client_phone_number',
        'client_name',
        'order_details',
        'restaurant_id',
        'delivered_at',
        'deliver_before',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'order_id');
    }


}
