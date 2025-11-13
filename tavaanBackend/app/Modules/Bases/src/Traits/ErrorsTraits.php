<?php

namespace holoo\modules\Bases\Traits;

use Illuminate\Support\Facades\Log;

trait ErrorsTraits
{
    public function getInfo(string $messages, mixed $phone): void
    {
        Log::info($messages, ['result' => $phone]);
    }
}
