<?php

namespace holoo\modules\Bases\servers\webServers;

interface ClientWordPressInterface
{
    public function request(...$data): mixed;
}
