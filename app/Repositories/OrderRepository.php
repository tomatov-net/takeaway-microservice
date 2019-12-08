<?php


namespace App\Repositories;


use App\Enums\MessageTypeEnum;
use App\Events\OrderStateChanged;
use App\Models\Order;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class OrderRepository
 * @package App\Repositories
 */
class OrderRepository
{
    /**
     * Create new order from request data
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $restaurant = RestaurantRepository::find($data['restaurant_id']);

        $order = $restaurant->orders()->create($data);

        return $order;
    }

    /**
     * Confirm order and send message
     *
     * @param int $orderId
     */
    public function confirm(int $orderId): void
    {
        $order = self::find($orderId);
        $restaurant = $order->restaurant;

        $order->deliver_before = $this->getDeliverBeforeTime($restaurant);
        $order->save();

        event(new OrderStateChanged($orderId, MessageTypeEnum::INITIAL));
    }

    /**
     * Check if order is confirmed
     *
     * @param int $orderId
     * @return bool
     */
    public function isConfirmed(int $orderId): bool
    {
        $order = self::find($orderId);
        return $order->messages()->count() > 0 && $order->deliver_before !== null;
    }

    /**
     * Check if order is delivered
     *
     * @param int $orderId
     * @return bool
     */
    public function isDelivered(int $orderId): bool
    {
        $order = self::find($orderId);
        return $order->delivered_at !== null;
    }

    /**
     * Mark order as delivered
     *
     * @param int $orderId
     * @return Order
     */
    public function deliver(int $orderId): Order
    {
        $order = self::find($orderId);
        $order->delivered_at = now();
        $order->save();

        return $order;
    }

    /**
     * Get order delivery deadline (Y.m.d H:i:s)
     *
     * @param Restaurant $restaurant
     * @return Carbon
     */
    public function getDeliverBeforeTime(Restaurant $restaurant): Carbon
    {
        $restaurantRepository = new RestaurantRepository();
        $minutesOfDelivery = $restaurantRepository->getDeliveryTime($restaurant);
        return now()->addMinutes($minutesOfDelivery);
    }

    /**
     * Find Order by id
     *
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        return Order::find($id);
    }

    /**
     * Get all delivered orders, older than $minutes,
     * without final message
     *
     * @param int $minutes
     * @return Collection
     */
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
