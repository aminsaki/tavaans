<?php

namespace App\Modules\Authentications\src\Repositories;

interface AuthsInterface
{

    public function loginUser($data):mixed;
}
