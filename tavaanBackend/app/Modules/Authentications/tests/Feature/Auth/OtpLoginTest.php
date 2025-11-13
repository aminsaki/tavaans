<?php

namespace App\Modules\Authentications\tests\Feature\Auth;

use App\Modules\Authentications\tests\TestCase;

class OtpLoginTest extends  TestCase
{


    public function  test_use_cat_request_otp_and_event_is_dispatchedT(): void
    {

        $response =$this->get(route('authentications?module=09904289707'));

        $response->assertStatus(200);

    }
}
