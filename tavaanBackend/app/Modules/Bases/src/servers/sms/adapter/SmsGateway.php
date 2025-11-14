<?php

namespace holoo\modules\Bases\servers\sms\adapter;

interface SmsGateway
{
    public function sendText(string $mobile, string $message , );


     public function sendPattern(string $mobile , array $params = []): bool;


}
