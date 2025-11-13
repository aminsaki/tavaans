<?php

namespace App\Modules\Bases\src\servers\caches;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CacheService
{
    public  function getCacheKey($model): string
    {
        return get_class($model) . '_cache';
    }

    public static function create(): CacheService
    {
        return new self();
    }

    public  function get($model): mixed
    {
        $cacheKey = $this->getCacheKey($model);
        try {
            return Cache::get($cacheKey);
        } catch (Exception $e) {
            Log::error("Error retrieving cache for {$cacheKey}: " . $e->getMessage());
            return null;
        }
    }
    public  function put($model, $data): void
    {
        $cacheKey = $this->getCacheKey($model);
        try {
            Cache::put($cacheKey, $data);
        } catch (Exception $e) {
            Log::error("Error putting cache for {$cacheKey}: " . $e->getMessage());
        }
    }
    public  function clear($model): void
    {
        $cacheKey = self::getCacheKey($model);
        try {
            Cache::forget($cacheKey);
        } catch (Exception $e) {
            // لاگ کردن خطا هنگام حذف کش
            Log::error("Error clearing cache for {$cacheKey}: " . $e->getMessage());
        }
    }

}
