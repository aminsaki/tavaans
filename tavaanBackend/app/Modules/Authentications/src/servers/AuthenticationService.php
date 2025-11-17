<?php

namespace holoo\modules\Authentications\servers;

use App\Modules\Authentications\src\Repositories\AuthsInterface;
use holoo\modules\Bases\Helper\Responses;


class AuthenticationService
{

    public function __construct(public AuthsInterface $authentication, public Responses $responses)
    {
    }

    public function login($request)
    {
        $mobile = $request['mobile'];
        $user = $this->authentication->firstWhereModle(['mobile' => $mobile]);

        if (!$user) {
            return $this->responses->notFound('', trans('validation.Otp_search'));
        }
        return $this->authentication->loginUser($request);

    }

}
