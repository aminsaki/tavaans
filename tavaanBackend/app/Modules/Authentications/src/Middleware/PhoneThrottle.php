<?php

namespace holoo\modules\Authentications\Middleware;


use holoo\modules\Bases\Helper\Responses;
use Illuminate\Routing\Middleware\ThrottleRequests;

class PhoneThrottle extends ThrottleRequests
{
    protected function resolveRequestSignature($request): string
    {
        return $request->ip() . '|' . $request->input('phone');
    }


    protected function buildException($request, $key, $maxAttempts, $responseCallback = null): \Illuminate\Http\Exceptions\HttpResponseException|\Illuminate\Http\JsonResponse|\Illuminate\Http\Exceptions\ThrottleRequestsException
    {
        $retryAfter = $this->limiter->availableIn($key);

        $response = Responses::create()->notFound(
            '',
            'شما بیش از حد تلاش کرده‌اید. لطفاً بعد از ' . $retryAfter . ' ثانیه دوباره تلاش کنید.'
        );

        // پرتاب کردن HttpResponseException
        throw new \Illuminate\Http\Exceptions\HttpResponseException($response);
    }

}
