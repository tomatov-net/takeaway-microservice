<?php

namespace Tests;

use App\Models\Order;
use App\Models\Restaurant;
use App\Repositories\MessageRepository;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function getRandomOrder()
    {
        $restaurant = Restaurant::inRandomOrder()->first();
        return [
            'restaurant_id' => $restaurant->id,
            'client_phone_number' => "+".rand(1, 7).rand(10000000000, 9999999999),
            'client_name' => Str::random(10),
            'order_details' => Str::random(30),
        ];
    }

    public function createRandomOrder($messageType = null)
    {
        $orderData = $this->getRandomOrder();
        $order = Order::create($orderData);

        if ($messageType) {
            $order->deliver_before = now()->addMinutes(rand(50, 120));
            $order->save();

            $message = new MessageRepository();
            $message->create($order->id, $messageType);
        }

        return $order;
    }
}
