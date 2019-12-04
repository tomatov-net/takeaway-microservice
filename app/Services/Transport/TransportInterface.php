<?php

namespace App\Services\Transport;

interface TransportInterface
{
    /**
     * @param $method
     * @param $url
     * @param $data
     * @param $headers
     * @return mixed
     */
    public function request($method, $url, $data, $headers = []);

}
