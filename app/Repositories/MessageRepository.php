<?php


namespace App\Repositories;


use App\Enums\MessageTypeEnum;
use App\Models\Message;
use App\Models\Order;

/**
 * Class MessageRepository
 * @package App\Repositories
 */
class MessageRepository
{
    /**
     * Generate message text to send it to client
     *
     * @param Order $order
     * @param string $type
     * @return string
     */
    public function getMessageByOrder(Order $order, string $type = MessageTypeEnum::INITIAL): string
    {
        if ($type === MessageTypeEnum::INITIAL) {
            $time = $order->deliver_before->format('d.m.Y H:i');
            $restaurantName = $order->restaurant->name;
            return "Dear {$order->client_name}, thank you for your order in {$restaurantName}. It will be delivered before {$time}.";
        }

        return "{$order->client_name}, we hope you enjoyed the food. Thank you and have a good time!";
    }

    /**
     * Create message
     *
     * @param int $orderId
     * @param string $type
     * @return array
     */
    public function create(int $orderId, string $type): array
    {
        $order = OrderRepository::find($orderId);
        $messageTypeId = MessageTypeRepository::getIdByType($type);
        $messageText = $this->getMessageByOrder($order, $type);

        Message::create([
            'text' => $messageText,
            'message_type_id' => $messageTypeId,
            'order_id' => $orderId,
        ]);

        return [
            'message' => $messageText,
            'to' => $order->client_phone_number,
        ];
    }
}
