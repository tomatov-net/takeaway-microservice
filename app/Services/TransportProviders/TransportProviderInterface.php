<?php

namespace App\Services\TransportProviders;

interface TransportProviderInterface
{
    public function sendSms($to, $message, $data = []);
}
