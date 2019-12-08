<?php


namespace App\Services\TransportProviders;


use App\Services\Transport\GuzzleTransport;
use App\Services\Transport\TransportInterface;

/**
 * Class DefaultProvider
 * @package App\Services\TransportProviders
 */
class DefaultProvider
{
    /**
     * Get default sms provider from config file (services.sms.default)
     *
     * @param TransportInterface $transport
     * @return TransportProviderInterface
     */
    public static function getDefaultProvider(TransportInterface $transport): TransportProviderInterface
    {
        $defaultNameByConfig = config('services.sms.default');
        $defaultProvider = config("services.sms.providers.{$defaultNameByConfig}");
        return $defaultProvider ? new $defaultProvider['class']($transport) : null;
    }
}
