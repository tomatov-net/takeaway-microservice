<?php

namespace App\Listeners;

use App\Events\OrderConfirmed;
use App\Jobs\SendTextMessage;
use App\Repositories\MessageRepository;
use App\Repositories\OrderRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserOrderNotification
{
    private $orderRepository;

    private $messageRepository;

    /**
     * Create the event listener.
     *
     * @param OrderRepository $orderRepository
     * @param MessageRepository $messageRepository
     */
    public function __construct(OrderRepository $orderRepository, MessageRepository $messageRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->messageRepository = $messageRepository;
    }

    /**
     * Handle the event.
     *
     * @param  OrderConfirmed  $event
     * @return void
     */
    public function handle(OrderConfirmed $event)
    {
        $orderId = $event->orderId;
        $messageType = $event->messageType;
        $message = $this->messageRepository->create($orderId, $messageType);
        dispatch(new SendTextMessage($message['message'], $message['to']));
    }
}
