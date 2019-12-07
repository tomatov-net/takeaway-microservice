<?php


namespace App\Models\ScopeQueries;


use App\Enums\MessageTypeEnum;

trait OrderScopes
{
    public function scopeDelivered($q)
    {
        return $q->whereNotNull('delivered_at');
    }

    public function scopeWithoutFinalMessage($q)
    {
        return $q->whereDoesntHave('messages.message_type', function ($name) {
            $name->where('name', MessageTypeEnum::FINAL);
        });
    }
}
