<?php

namespace Tests\Unit;

use App\Enums\MessageTypeEnum;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
