<?php

namespace App\Service;

use Twilio\Rest\Client;

class SmSGenerator
{
    private $twilioClient;
    private $fromNumber;

    public function __construct(string $accountSid, string $authToken, string $fromNumber)
    {
        $this->twilioClient = new Client($accountSid, $authToken);
        $this->fromNumber = $fromNumber;
    }

    public function sendSms(string $toNumber, string $name, string $text)
    {
        $message = $this->twilioClient->messages->create(
            $toNumber,
            [
                'from' => $this->fromNumber,
                'body' => "$name, your CarthagoSmart account has been blocked.",
            ]
        );
    }
}
