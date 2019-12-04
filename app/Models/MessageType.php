<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageType extends Model
{
    protected $fillable = [
        'name'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class, 'message_type_id');
    }
}
