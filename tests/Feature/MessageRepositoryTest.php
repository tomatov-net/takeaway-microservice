<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\MessageType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessageRepositoryTest extends TestCase
{
//    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertCount(2, MessageType::all());

//        $response->assertStatus(200);
    }
}
