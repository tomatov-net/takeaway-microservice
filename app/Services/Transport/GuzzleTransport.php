<?php

namespace App\Services\Transport;

use GuzzleHttp\Client;

class GuzzleTransport implements TransportInterface
{
    private $client;
    private $sendAs;

    function __construct(array $options = [])
    {
        $this->client = new Client($options);
        $this->sendAs = $options['send_as'] ?? 'json';
    }

    public function request(string $method, string $url, array $data, array $headers = [], string $as = 'json'): string
    {
        try {
            $result = $this->client->request($method, $url, [
                $as => $data,
                'headers' => $headers
            ]);

            $content = $result->getBody()->getContents();

            return $content;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
