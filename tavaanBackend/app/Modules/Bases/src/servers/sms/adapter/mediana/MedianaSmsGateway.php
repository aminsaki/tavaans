<?php

namespace holoo\modules\Bases\servers\sms\adapter\mediana;

use GuzzleHttp\Exception\RequestException;
use holoo\modules\Bases\servers\sms\adapter\SmsGateway;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MedianaSmsGateway implements SmsGateway
{
    public function sendText(string $mobile, string $message): bool
    {
        $url = 'https://api.mediana.ir/sms/v1/send/sms';

        $payload = [
            "type"        => "Informational",   // همون که دادی
            "recipients"  => [$mobile],        // آرایه از شماره‌ها
            "messageText" => $message,         // متن پیام
        ];

        try {
            $response = Http::withHeaders([
              'X-API-KEY' => 'ycyYY8HI81T+hdaMObOrMjcfZvSnkmx3ROENdmUdQ=',
              'Accept' => 'application/json',
              'Content-Type' => 'application/json',
            ])->post($url, $payload);

            if (! $response->successful()) {
                Log::error('Mediana sendText failed', [
                    'status'  => $response->status(),
                    'body'    => $response->body(),
                    'payload' => $payload,
                ]);
                return false;
            }

            return true;
        } catch (RequestException $e) {
            Log::error('Mediana sendText connection error', [
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }



    public function sendPattern(string $mobile, string $patternCode, array $params = []): bool
    {
        // این دقیقا همون چیزیه که تو داک مدیانا نوشته:
        // "Send a message using a predefined pattern code ..."
        // ولی endpoint و نام فیلدها رو از خود داک بردار و جایگزین کن

        $url = rtrim(config('mediana.base_url'), '/') . '/api/v1/messages/send-by-pattern'; // مثال فرضی

        $payload = [
            // نام فیلدها رو طبق داک عوض کن
            'to'          => $mobile,        // شاید 'recipient' یا 'destination' باشد
            'patternCode' => $patternCode,   // یا 'pattern_code'
            'inputData'   => $params,        // یا 'values', 'args', ...
            // 'from'     => config('mediana.sender'),
        ];

        $response = Http::withHeaders($this->headers())
            ->post($url, $payload);

        if (! $response->successful()) {
            Log::error('Mediana sendPattern failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
                'payload'=> $payload,
            ]);
            return false;
        }

        // این جا هم می‌تونی بر اساس فیلد مثل success / statusCode چک دقیق‌تر کنی
        return true;
    }

    protected function headers(): array
    {
        return [
            // طبق داک مدیانا:
            // ممکنه 'Authorization' => 'Bearer ' . config('mediana.api_key') باشه
            // یا 'ApiKey' => config('mediana.api_key')
            'Authorization' => 'Bearer ' . config('mediana.api_key'),
            'Accept'        => 'application/json',
        ];
    }
}
