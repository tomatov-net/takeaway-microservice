<?php

namespace App\Services\TransportProviders;

use App\Services\Transport\GuzzleTransport;
use App\Services\Transport\TransportInterface;
use Illuminate\Support\Facades\Log;

class NexmoProvider implements TransportProviderInterface
{
    protected $key;
    protected $secret;
    protected $from;
    protected $transport;

    public function __construct(TransportInterface $transport)
    {
        $path = 'services.sms.providers.nexmo.';

        $this->key = config($path.'key');
        $this->secret = config($path.'secret');
        $this->from = env('FROM_SMS_TITLE');
        $this->transport = $transport;
    }

    public function sendSms($to, $message, $data = []): string
    {
        $result = $this->transport->request('post', 'https://rest.nexmo.com/sms/json', [
            'api_key' => $this->key,
            'api_secret' => $this->secret,
            'from' => $this->from,
            'to' => $to,
            'text' => $message,
        ]);

        $this->log($result);

        return $result;
    }

    private function log($data)
    {
        Log::info($data);
    }
}
