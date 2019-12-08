<?php


namespace App\Repositories;


use App\Enums\MessageTypeEnum;
use App\Events\OrderStateChanged;
use App\Models\Order;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderRepository
{
    public function create(array $data)
    {
        $restaurant = RestaurantRepository::find($data['restaurant_id']);

        $order = $restaurant->orders()->create($data);

        return $order;
    }

    public function confirm(int $orderId): void
    {
        $order = self::find($orderId);
        $restaurant = $order->restaurant;

        $order->deliver_before = $this->getDeliverBeforeTime($restaurant);
        $order->save();

        event(new OrderStateChanged($orderId, MessageTypeEnum::INITIAL));
    }

    public function isConfirmed(int $orderId): bool
    {
        $order = self::find($orderId);
        return $order->messages()->count() > 0 && $order->deliver_before !== null;
    }

    public function isDelivered(int $orderId): bool
    {
        $order = self::find($orderId);
        return $order->delivered_at !== null;
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
