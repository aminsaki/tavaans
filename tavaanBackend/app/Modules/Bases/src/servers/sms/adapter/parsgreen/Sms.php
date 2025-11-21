<?php

namespace holoo\modules\Bases\servers\sms\adapter\parsgreen;

use holoo\modules\Bases\servers\sms\SmsInterface;
use Illuminate\Support\Facades\Http;

class Sms implements SmsInterface
{
    protected mixed $sender;

    protected mixed $gateway_url;

    protected mixed $api_key;

    /**
     * This file passes the items to the item variables before calling the settings that you read from the Config folder
     * ParsgreenSms constructor.
     */
    public function __construct()
    {
        $this->gateway_url = config('client.parsgreenSms.gateway');
        $this->api_key = config('client.parsgreenSms.api_key');
        $this->sender = config('client.parsgreenSms.sender');
    }

    /**
     * This method is called from the interface file and is responsible for passing the information given to it in the control
     */
    public function send(mixed $number, string $text, $date = null, $type = null, $localid = null): mixed
    {
        return $this->_send($number, $this->sender, $text);
    }

    /**
     * * This method is responsible for receiving this information, pass it to the sending method, and also checks
     * if the given value is passed to the executable method in the form of a presentation template.
     *
     * @return null
     */
    private function _send($receptor, $sender, $message)
    {
        ///The condition checks to see if there is a presentation
        return $this->execute( $this->gateway_url, ['SmsBody' => $message, 'Mobiles' => $receptor, 'SmsNumber' => $sender]);
    }
    private function execute(string $url = null, array $body)
    {
        $query = http_build_query([
            'username' => 'torfe.negar_holoocloud',
            'password' => 'h@254sms!', // توجه: اگر در .env بود از env() استفاده کن
            'from' => '300023067',
            'to' =>  $body['Mobiles'],
            'message' => $body['SmsBody'],
        ]);

        $url = "http://parsasms.com/tools/urlservice/send/?" . $query;

        $response = Http::post($url);
        return $response->successful();

    }

    /**
     * @return string
     */
    private function get_path(string $method = 'Message', string $type = 'SendSms')
    {
        return sprintf($this->gateway_url, $method, $type);
    }
}
