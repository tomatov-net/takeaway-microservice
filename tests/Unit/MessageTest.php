<?php

namespace Tests\Unit;

use App\Enums\MessageTypeEnum;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessageTest extends TestCase
{
    /** @test*/
    public function shouldGetMessageTest()
    {
        Order::select('*')->delete();
        $repository = new OrderRepository();
        $randomOrder = $this->getRandomOrder();
        $randomOrder['delivered_at'] = now()->subHours(2);
        $randomOrder['deliver_before'] = now()->subHours(2);
        $randomOrder = Order::create($randomOrder);

        $orders = $repository->getRecentlyDeliveredOrders(90);

        foreach ($orders as $order) {
            if ($order->id === $randomOrder->id) {
                $this->assertTrue($order->id === $randomOrder->id);
                return;
            }
        }
        $this->assertTrue(false);
    }

    /** @test*/
    public function shouldNotGetMessageTest()
    {
        Order::select('*')->delete();
        $repository = new OrderRepository();
        $randomOrder = $this->getRandomOrder();
        $randomOrder['delivered_at'] = now();
        $randomOrder['deliver_before'] = now()->subMinutes(2);
        $randomOrder = Order::create($randomOrder);

        $orders = $repository->getRecentlyDeliveredOrders(90);

        foreach ($orders as $order) {
            if ($order->id === $randomOrder->id) {
                $this->assertFalse($order->id === $randomOrder->id);
                return;
            }
        }
        $this->assertTrue(true);
    }
}
