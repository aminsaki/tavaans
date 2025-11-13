<?php

namespace holoo\modules\Bases\servers\sms;

interface SmsInterface
{
    public function send(mixed $number, string $text, $date = null, $type = null, $localid = null): mixed;
}
