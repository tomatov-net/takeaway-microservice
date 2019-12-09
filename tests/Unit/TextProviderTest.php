<?php

namespace Tests\Unit;

use App\Services\Transport\GuzzleTransport;
use App\Services\TransportProviders\NexmoProvider;
use App\Services\TransportProviders\TwilioProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TextProviderTest extends TestCase
{
    /** @test */
    public function twilioTest()
    {
        $provider = new TwilioProvider(new GuzzleTransport());
        $response = $provider->sendSms(env('FROM_SMS_NUMBER'), 'test');
        $response = json_decode($response, true);

        $this->assertTrue($response['error_code'] === null);
    }

    /** @test */
    public function nexmoTest()
    {
        $provider = new NexmoProvider(new GuzzleTransport());
        $response = $provider->sendSms(env('FROM_SMS_NUMBER'), 'test');
        $response = json_decode($response, true);

        $this->assertTrue($response['messages'][0]['status'] === "0");
    }
}
