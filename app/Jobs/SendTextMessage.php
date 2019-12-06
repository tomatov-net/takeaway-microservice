<?php

namespace App\Jobs;

use App\Repositories\MessageRepository;
use App\Services\Transport\GuzzleTransport;
use App\Services\TransportProviders\DefaultProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTextMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $message;
    private $to;

    /**
     * Create a new job instance.
     *
     * @param $message
     * @param $to
     */
    public function __construct($message, $to)
    {
        $this->message = $message;
        $this->to = $to;
    }

    /**
     * Execute the job.
     *
     * @param GuzzleTransport $transport
     * @return void
     */
    public function handle(GuzzleTransport $transport)
    {
        $provider = DefaultProvider::getDefaultProvider($transport);
        $provider->sendSms($this->to, $this->message);
    }
}
