<?php

namespace App\Services\TransportProviders;

use App\Services\Transport\TransportInterface;
use Illuminate\Support\Facades\Log;

/**
 * Class TwilioProvider
 * @package App\Services\TransportProviders
 */
class TwilioProvider implements TransportProviderInterface
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
     * TwilioProvider constructor.
     * @param TransportInterface $transport
     */
    public function __construct(TransportInterface $transport)
    {
        $path = 'services.sms.providers.twilio.';

        $this->key = config($path.'key');
        $this->secret = config($path.'secret');
        $this->from = config($path.'from_phone_number');
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
        $base = base64_encode("{$this->key}:{$this->secret}");
        $url = "https://api.twilio.com/2010-04-01/Accounts/{$this->key}/Messages.json";
        $result = $this->transport->request('post', $url, [
            'api_key' => $this->key,
            'api_secret' => $this->secret,
            'From' => $this->from,
            'To' => $to,
            'Body' => $message,
        ],[
            'Authorization' => "Basic $base"
        ], 'form_params');

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
