<?php


namespace App\Repositories;


use App\Enums\MessageTypeEnum;
use App\Models\Message;
use App\Models\Order;

class MessageRepository
{
    /**
     * @param Order $order
     * @param string $type
     * @return string
     */
    public function getMessageByOrder(Order $order, string $type = MessageTypeEnum::INITIAL): string
    {
        if ($type === MessageTypeEnum::INITIAL) {
            $time = $order->deliver_before->format('d.m.Y H:i');
            return "Dear {$order->client_name}, thank you for your order. It will be delivered before {$time}.";
        }

        return "{$order->client_name}, we hope you enjoyed the food. Thank you and have a good time!";
    }

    /**
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
