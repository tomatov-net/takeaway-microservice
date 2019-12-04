<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'text',
        'order_id',
        'message_type_id',
    ];

    public function restaurant_order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function message_type()
    {
        return $this->belongsTo(MessageType::class, 'message_type_id');
    }
}
