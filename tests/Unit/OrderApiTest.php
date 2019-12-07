<?php

namespace Tests\Unit;

use App\Enums\MessageTypeEnum;
use App\Models\Order;
use App\Models\Restaurant;
use App\Repositories\MessageRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    /** @test */
    public function createTest()
    {
        $response = $this->post('/api/orders/create', $this->getRandomOrder());

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'created',
            ]);
    }

    /** @test*/
    public function confirmTest()
    {
        $randomOrder = $this->createRandomOrder();
        $response = $this->post("/api/orders/confirm/{$randomOrder->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'confirmed',
            ]);
    }

    /** @test*/
    public function nonExistedOrderIsCalledTest()
    {
        $nonExistingId = Order::max('id') + rand(1, 10);
        $response = $this->post("/api/orders/confirm/{$nonExistingId}");
        $response->assertStatus(400)
            ->assertJson([
                'message' => 'The given data was invalid.',
                "status" => "not_exists",
            ])
        ;
    }

    /** @test*/
    public function deliverTest()
    {
        $randomOrder = $this->createRandomOrder(MessageTypeEnum::INITIAL);
        $response = $this->post("/api/orders/deliver/{$randomOrder->id}");
        $response->assertStatus(200)
            ->assertJson([
                "status" => "delivered",
            ]);
    }

    private function getRandomOrder()
    {
        $restaurant = Restaurant::inRandomOrder()->first();
        return [
            'restaurant_id' => $restaurant->id,
            'client_phone_number' => "+".rand(1, 7).rand(10000000000, 9999999999),
            'client_name' => Str::random(10),
            'order_details' => Str::random(30),
        ];
    }

    private function createRandomOrder($messageType = null)
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
