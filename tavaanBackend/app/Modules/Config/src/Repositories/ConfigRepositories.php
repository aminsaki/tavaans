<?php

namespace holoo\modules\Config\Repositories;

use holoo\modules\Config\Models\Config;
use holoo\modules\Bases\Http\Contracts\BaseRepository;

class ConfigRepositories extends BaseRepository  implements ConfigInteface
{
    public function model(): mixed
    {
        return Config::class;
    }

}
