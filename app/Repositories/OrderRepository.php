<?php


namespace App\Repositories;


use App\Enums\MessageTypeEnum;
use App\Events\OrderStateChanged;
use App\Models\Order;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function create(array $data)
    {
        $restaurant = RestaurantRepository::find($data['restaurant_id']);

        $data['deliver_before'] = $this->getDeliverBeforeTime($restaurant);

        $order = $restaurant->orders()->create($data);

        return $order;
    }

    public function confirm(int $orderId): void
    {
        event(new OrderStateChanged($orderId, MessageTypeEnum::INITIAL));
    }

    public function deliver(int $orderId): Order
    {
        $order = self::find($orderId);
        $order->delivered_at = now();
        $order->save();

        return $order;
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

    public function getRecentlyDeliveredOrders(int $minutes):Collection
    {
        $time = now()->subMinutes($minutes);
        $orders = Order::delivered()
            ->withoutFinalMessage()
            ->where('delivered_at', '<', $time)
            ->get()
        ;

        return $orders;
    }
}
