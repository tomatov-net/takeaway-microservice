<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiStepsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testApiSteps()
    {
        /* step 1 - CREATE*/
        $response = $this->post('/api/orders/create', $this->getRandomOrder());

        $orderId = $response->json('order_id');

        $this->assertDatabaseHas('orders', [
            'id' => $orderId
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'created',
            ]);

        /* step 2 - CONFIRM */
        $response = $this->post("/api/orders/confirm/{$orderId}");

        $this->assertDatabaseHas('messages', [
            'order_id' => $orderId,
            'message_type_id' => 1,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'confirmed',
            ]);

        /* step 3 - DELIVER */
        $response = $this->post("/api/orders/deliver/{$orderId}");
        $response->assertStatus(200)
            ->assertJson([
                "status" => "delivered",
            ]);
    }
}
