<?php

namespace App\Console\Commands;

use App\Enums\MessageTypeEnum;
use App\Events\OrderStateChanged;
use App\Repositories\OrderRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckOrderTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:check-time {--minutes=90}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'By this command we count {minutes} after delivery and send sms to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param OrderRepository $orderRepository
     * @return mixed
     */
    public function handle(OrderRepository $orderRepository)
    {
        $minutes = $this->option('minutes');
        $orders = $orderRepository->getRecentlyDeliveredOrders($minutes);
        foreach ($orders as $order) {
            event(new OrderStateChanged($order->id, MessageTypeEnum::FINAL));
        }
    }
}
