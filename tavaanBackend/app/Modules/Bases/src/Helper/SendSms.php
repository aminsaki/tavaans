<?php

declare(strict_types=1);

namespace holoo\modules\Bases\Helper;

use Illuminate\Support\Facades\Http;

class SendSms
{
    protected mixed $sender;

    protected mixed $gateway_url;

    protected mixed $api_key;

    private $insecure = false;

    public function __construct()
    {
        $this->gateway_url = config('client.Kavenegar.gateway');
        $this->api_key = config('client.Kavenegar.api_key');
        $this->sender = config('client.Kavenegar.sender');
    }

    public static function create(): SendSms
    {
        return new static();
    }

    public function sendSms(mixed $number, string $text, $date = null, $type = null, $localid = null): mixed
    {

        $path = $this->get_path('send', 'sms', $number, $text);
        $params = [
            'receptor' => $number,
            'sender' => $this->sender,
            'message' => $text,
            'date' => $date,
            'type' => $type,
            'localid' => $localid,
        ];

        return $this->execute($path, $params);
    }

    public function execute($url, $data = null)
    {
        $headers = [
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'charset: utf-8',
            'Authorization:'.' '.$this->api_key,
        ];

        $response = Http::withHeaders([
            $headers,
        ])->get($url);

        return $response->successful();
    }

    public function get_path($method, $base = 'sms', $receptor = null, $text = null)
    {
        return sprintf($this->gateway_url, $this->insecure == true ? 'http' : 'https', $this->api_key, $base, $method, $receptor, $this->sender, $text);

    }
}
