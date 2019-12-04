<?php

namespace App\Services\TransportProviders;

use App\Services\Transport\TransportInterface;

class TwilioProvider implements TransportProviderInterface
{
    protected $key;
    protected $secret;
    protected $from;
    protected $transport;

    public function __construct(TransportInterface $transport)
    {
        $path = 'services.sms.providers.twilio.';

        $this->key = config($path.'key');
        $this->secret = config($path.'secret');
        $this->from = config($path.'from_phone_number');
        $this->transport = $transport;
    }

    public function sendSms($to, $message, $data = []): string
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

        return $result;
    }
}
