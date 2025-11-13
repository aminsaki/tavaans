<?php
namespace holoo\modules\Authentications\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * TODO
 */
trait OtpTrait
{
    // Helper functions

    public function setCacheAddMinutes($code, $key, $value, $key2 = null, $value2 = null): void
    {
        if (! empty($key)) {
            $cacheKey = $key.'_'.$code;
            $this->putToCache($cacheKey, $value);
        }
        if (! empty($key2)) {
            $cacheKey2 = $key2.'_'.$code;
            $this->putToCache($cacheKey2, $value2);
        }
    }

    private function putToCache($key, $value): void
    {
        Cache::put($key, $value, now()->addMinutes(2));
    }

    public function getCacheAddMinutes($key, $code)
    {
        $cacheKey = $key.'_'.$code;

        return Cache::get($cacheKey);
    }

    private function getCache($key, $valKey): mixed
    {
        return $this->getCacheAddMinutes($key, $valKey) ?? '';
    }

    public function getArr(Request $request): array
    {
        $types = [
            'immigrant' => 'مهاجر',
            'legal' => 'حقوقی',
            'real' => 'حقیقی',
        ];

        return ['type' => $types[$request->customer_type] ?? null];
    }
}
