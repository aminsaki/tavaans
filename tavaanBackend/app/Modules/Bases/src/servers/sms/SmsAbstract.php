<?php

namespace holoo\modules\Bases\servers\sms;

abstract class SmsAbstract
{
    /**
     * @return mixed
     */
    abstract protected function execute($url, $data = null);

    /**
     * @return mixed
     */
    abstract protected function get_path($method, $base = 'sms');

    /**
     * @return mixed
     */
    abstract protected function VerifyLookup($receptor, $token, $template, $type = 'sms');
}
