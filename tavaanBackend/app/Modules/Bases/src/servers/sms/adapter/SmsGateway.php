<?php

namespace holoo\modules\Bases\servers\sms\adapter;

interface SmsGateway
{
    public function sendText(string $mobile, string $message): bool;


     public function sendPattern(string $mobile, string $message): bool;


}
