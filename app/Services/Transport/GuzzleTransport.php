<?php

namespace App\Services\Transport;

use GuzzleHttp\Client;

class GuzzleTransport implements TransportInterface
{
    private $client;

    function __construct($options)
    {
        $this->client = new Client($options);
    }

    public function request($method, $url, $data, $headers = [])
    {
        try {
            $result = $this->client->request($method, $url, [
                'json' => $data,
                'headers' => $headers
            ]);

            $content = $result->getBody()->getContents();

            return $content;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
