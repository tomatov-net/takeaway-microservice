<?php

namespace App\Services\TransportProviders;

use App\Services\Transport\GuzzleTransport;
use App\Services\Transport\TransportInterface;
use Illuminate\Support\Facades\Log;

/**
 * Class NexmoProvider
 * @package App\Services\TransportProviders
 */
class NexmoProvider implements TransportProviderInterface
{
    /**
     * @var string|mixed
     */
    protected $key;
    /**
     * @var string|mixed
     */
    protected $secret;
    /**
     * @var string|mixed
     */
    protected $from;
    /**
     * @var TransportInterface
     */
    protected $transport;

    /**
     * NexmoProvider constructor.
     * @param TransportInterface $transport
     */
    public function __construct(TransportInterface $transport)
    {
        $path = 'services.sms.providers.nexmo.';

        $this->key = config($path.'key');
        $this->secret = config($path.'secret');
        $this->from = env('FROM_SMS_TITLE');
        $this->transport = $transport;
    }


    /**
     * @param string $to
     * @param string $message
     * @param array $data
     * @return string
     */
    public function sendSms(string $to, string $message, array $data = []): string
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

    /**
     * @param string $data
     */
    private function log(string $data)
    {
        Log::info($data);
    }
}
