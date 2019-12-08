<?php

namespace App\Services\TransportProviders;

/**
 * Interface TransportProviderInterface
 * @package App\Services\TransportProviders
 */
interface TransportProviderInterface
{
    /**
     * Send sms to recipient, using one of described in config
     *
     * @param string $to
     * @param string $message
     * @param array $data
     * @return string
     */
    public function sendSms(string $to, string $message, array $data = []): string;
}
