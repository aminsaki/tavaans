<?php

namespace holoo\modules\Bases\servers\sms\adapter\Kavenegars;

use holoo\modules\Bases\servers\sms\SmsAbstract;
use holoo\modules\Bases\servers\sms\SmsInterface;
use Illuminate\Support\Facades\Http;

class Kavenegar extends SmsAbstract implements SmsInterface
{
    protected mixed $sender;

    protected mixed $gateway_url;

    protected mixed $api_key;

    private $insecure = false;

    /**
     * This file passes the items to the item variables before calling the settings that you read from the config folder
     * ParsgreenSms constructor.
     */
    public function __construct()
    {
        $this->gateway_url = config('client.Kavenegar.gateway');
        $this->api_key = config('client.Kavenegar.api_key');
        $this->sender = config('client.Kavenegar.sender');
    }

    public function send(mixed $number, string $text, $date = null, $type = null, $localid = null): mixed
    {
        $sender = (is_array($number)) ? implode(',', $this->sender) : $this->sender;

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
          return  json_decode($response , true);
    }

    public function get_path($method, $base = 'sms', $receptor = null, $text = null)
    {
        return sprintf($this->gateway_url, $this->insecure == true ? 'http' : 'https', $this->api_key, $base, $method, $receptor, $this->sender, $text);

    }

    public function VerifyLookup($receptor, $token, $template, $type = 'sms')
    {
        $path = $this->get_path('lookup', 'verify');
        $params = [
            'receptor' => $receptor,
            'token' => $token,
            'template' => $template,
            'type' => $type,
        ];

        if (func_num_args() > 5) {
            $arg_list = func_get_args();
            if (isset($arg_list[6])) {
                $params['token10'] = $arg_list[6];
            }
            if (isset($arg_list[7])) {
                $params['token20'] = $arg_list[7];
            }
        }

        return $this->execute($path, $params);
    }
}
