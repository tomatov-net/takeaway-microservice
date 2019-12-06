<?php


namespace App\Repositories;


use App\Enums\MessageTypeEnum;
use App\Models\Order;
use App\Models\Restaurant;
use Carbon\Carbon;

class OrderRepository
{
    public function create(array $data)
    {
        $restaurant = Restaurant::find($data['restaurant_id']);

        $data['deliver_before'] = $this->getDeliverBeforeTime($restaurant);

        $order = $restaurant->orders()->create($data);

        return $order;
    }

    public function confirm(int $orderId)
    {
        $messageRepository = new MessageRepository();
        $order = Order::find($orderId);

        $order->messages()->create([
            'text' => $messageRepository->getMessageByOrder($order),
            'message_type_id' => MessageTypeEnum::INITIAL,
        ]);
    }

    public function getDeliverBeforeTime(Restaurant $restaurant): Carbon
    {
        $restaurantRepository = new RestaurantRepository();
        $minutesOfDelivery = $restaurantRepository->getDeliveryTime($restaurant);
        return now()->addMinutes($minutesOfDelivery);
    }

    public static function find($id)
    {
        return Order::find($id);
    }
}
