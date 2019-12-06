<?php


namespace App\Repositories;


use App\Enums\MessageTypeEnum;
use App\Models\MessageType;

class MessageTypeRepository
{
    public static function getIdByType (string $type = MessageTypeEnum::INITIAL)
    {
        $messageType = MessageType::where('name', $type)->first();
        return $messageType->id ?? null;
    }
}
