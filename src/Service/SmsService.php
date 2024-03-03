<?php 

namespace App\Service;
use Twilio\Rest\Client;

class SmsService
{
    private $twilioClient;
    private $twilioPhoneNumber;

    public function __construct(string $twilioAccountSid, string $twilioAuthToken, string $twilioPhoneNumber)
    {
        $this->twilioClient = new Client($twilioAccountSid, $twilioAuthToken);
        $this->twilioPhoneNumber = $twilioPhoneNumber;
    }

    public function sendSms(string $to, string $message)
    {
        $this->twilioClient->messages->create(
            $to,
            [
                'from' => $this->twilioPhoneNumber,
                'body' => $message
            ]
        );
    }
}
