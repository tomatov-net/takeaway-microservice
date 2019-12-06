<?php

namespace App\Events;

use App\Repositories\OrderRepository;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStateConfirmed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderId;
    public $messageType;

    /**
     * Create a new event instance.
     *
     * @param int $orderId
     * @param string $messageType
     */
    public function __construct(int $orderId, string $messageType)
    {
        $this->orderId = $orderId;
        $this->messageType = $messageType;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
