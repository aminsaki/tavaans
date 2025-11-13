<?php

namespace holoo\modules\Bases\servers\bank;

interface PaymentGatewayInterface
{

    public function startPayment($amount, $desc, $mobile = null, $email = null , $id = null);

    public function verify($params);
}
