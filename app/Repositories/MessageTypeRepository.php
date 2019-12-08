<?php


namespace App\Repositories;


use App\Enums\MessageTypeEnum;
use App\Models\MessageType;

/**
 * Class MessageTypeRepository
 * @package App\Repositories
 */
class MessageTypeRepository
{
    /**
     * Get message type by name
     *
     * @param string $type
     * @return int|null
     */
    public static function getIdByType (string $type = MessageTypeEnum::INITIAL): ?int
    {
        $messageType = MessageType::where('name', $type)->first();
        return $messageType->id ?? null;
    }
}
