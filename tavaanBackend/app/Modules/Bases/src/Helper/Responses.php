<?php

namespace holoo\modules\Bases\Helper;

use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class Responses
{
    final public function __construct()
    {
    }
    public static function create(): Responses
    {
        return new self();
    }


    public function successLogin($data, $messages , $access_token = null): \Illuminate\Http\JsonResponse
    {
        return response()
            ->json([
                'status' => 'true',
                'data' => $data,
                'messages' => ($messages) ? $messages : 'list',
            ], Response::HTTP_OK)
            ->withHeaders([
                'Access-Control-Allow-Origin' => '*',
            ]);
    }

    public function successLogin_new($data, $messages , $access_token): \Illuminate\Http\JsonResponse
    {
        $accessToken = $access_token ?? null;

        $cookie = Cookie::make(
            'access_token',
            $accessToken,
            7 * 24 * 60, // مدت زمان کوکی به دقیقه (یک روز)
            '/', // مسیر کوکی
            null, // دامنه کوکی (به طور پیش‌فرض null)
            true, // secure (کوکی فقط در https)
            true, // HTTP-Only (غیر قابل دسترس توسط جاوا اسکریپت)
            false, // SameSite (غیر فعال کردن)
            'Strict' // سیاست SameSite برای افزایش امنیت
        );

        // بازگشت پاسخ با تنظیم کوکی
        return response()
            ->json([
                'status' => 'true',
                'data' => $data,
                'messages' => ($messages) ? $messages : '',
            ], Response::HTTP_OK)
            ->withCookie($cookie) // ارسال کوکی به همراه پاسخ
            ->withHeaders([
                'Access-Control-Allow-Origin' => '*',
            ]);
    }
    public function successCreate($data, $messages): \Illuminate\Http\JsonResponse
    {
        return response()
            ->json([
                'status' => 'true',
                'data' => $data,
                'messages' => ($messages) ? $messages : 'list',
            ], Response::HTTP_CREATED);
    }
    public function success($data, $messages): \Illuminate\Http\JsonResponse
    {
        return response()
            ->json([
                'status' => 'true',
                'data' => $data,
                'messages' => ($messages) ? $messages : 'list',
            ], Response::HTTP_OK);
    }

    public function notFound($data, $messages): \Illuminate\Http\JsonResponse
    {
        return response()
            ->json([
                'status' => 'false',
                'data' => ! empty($data) ? $data : '',
                'messages' => $messages,
            ], Response::HTTP_NOT_FOUND);
    }
    public function getStatus($data, $messages ,$errors): \Illuminate\Http\JsonResponse
    {
        return response()
            ->json([
                'status' => 'false',
                'data' => ! empty($data) ? $data : '',
                'messages' => $messages,
            ], $errors);
    }

    public function server_error($data, $messages): \Illuminate\Http\JsonResponse
    {
        return response()
            ->json([
                'status' => 'false',
                'data' => ! empty($data) ? $data : '',
                'messages' => $messages,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function Unauthorized($data, $messages): \Illuminate\Http\JsonResponse
    {
        return response()
            ->json([
                'status' => 'false',
                'data' => ! empty($data) ? $data : '',
                'messages' => $messages,
            ], Response::HTTP_UNAUTHORIZED);
    }
}
