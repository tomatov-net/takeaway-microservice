<?php


namespace App\Services\TransportProviders;


use App\Services\Transport\GuzzleTransport;
use App\Services\Transport\TransportInterface;

class DefaultProvider
{
    public static function getDefaultProvider(TransportInterface $transport): TransportProviderInterface
    {
        $defaultNameByConfig = config('services.sms.default');
        $defaultProvider = config("services.sms.providers.{$defaultNameByConfig}");
        return $defaultProvider ? new $defaultProvider['class']($transport) : null;
    }
}
