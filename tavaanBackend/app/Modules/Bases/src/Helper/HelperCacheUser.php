<?php

namespace holoo\modules\Bases\Helper;
use Illuminate\Support\Facades\Cache;

class HelperCacheUser
{
    public static function create(): HelperCacheUser
    {
        return new self;
    }

    public function add(string $params1 ,   string $params2 , array $data, int $minutes = 60)
    {
        return Cache::put($params1.'_'.$params2, json_encode($data) , $minutes);
    }

    public function exists(string $params1 ,   string $params2 ): bool
    {

        return Cache::has($params1.'_'.$params2);
    }

    public function get(string $params1 ,   string $params2)
    {
        if ($this->exists($params1 , $params2)) {
            return json_decode(Cache::get($params1.'_'.$params2), true);
        }
        return null;
    }

    public function delete(string $params1 ,   string $params2)
    {
        return Cache::forget($params1.'_'.$params2);
    }

}
