<?php

namespace App\Services\Transport;

interface TransportInterface
{
    /**
     * @param string $method
     * @param string $url
     * @param array $data
     * @param array $headers
     * @param string $as
     * @return string
     */
    public function request(string $method, string $url, array $data, array $headers = [], string $as = 'json'): string;
}
