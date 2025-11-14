<?php

namespace holoo\modules\Bases\servers\sms\adapter\mediana;

use Dflydev\DotAccessData\Data;
use GuzzleHttp\Exception\RequestException;
use holoo\modules\Bases\servers\sms\adapter\SmsGateway;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MedianaSmsGateway implements SmsGateway
{
    public function sendPattern(string $mobile,array $params = [] ): bool
    {
        $url = 'https://api.mediana.ir/sms/v1/send/pattern';
        $payload = [
            "patternCode" => $params['code'],
            "type"        => "Informational",   // همون که دادی
            "recipients"  => [$mobile],        // آرایه از شماره‌ها
            "parameters"=>[
                "Name" =>$params['name'],
            ]
        ];
        try {
            $response = Http::withHeaders([
              'X-API-KEY' => '27Gsunym8zB18zAdTDuKz6m8fYOn5sa0CBfPlHyuTc=',
              'Accept' => 'application/json',
              'Content-Type' => 'application/json',
            ])->post($url, $payload);

            if (!$response->successful()) {
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


    public function sendText(string $mobile, string $message)
    {
        // TODO: Implement sendText() method.
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
