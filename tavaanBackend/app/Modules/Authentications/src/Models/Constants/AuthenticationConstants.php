<?php

namespace App\Modules\Authentications\src\Models\Constants;

class AuthenticationConstants
{

    const  PHONE = 'phone';

    const  EMAIL = 'email';

    const  USERNAME = 'username';

    const  PASSWORD = 'password';

    const PASSWORD_CONFIRMATION = 'password_confirmation';

    const  SUBJECT = 'subject';

    const  MESSAGE = 'message';

    const  USERID = 'user_id';

    const  ID = 'id';

    const  DATE = 'date';

    const  PERSONNEL_CODE = 'personnel_code';

    const  UNIT = 'unit';

    const  PROFILE = 'profile';

    const API_ROUTE = '/routes/api.php';

    const CONTROLLER_ROUTE = 'crm\\modules\\authentication\\Http\\Controllers';

    const ROUTE = '/register/visitor/';

    const TOKEN = 'token';

    const CODE = 'code';

    const UNIQUE_ID = 'unique_id';

    const PASSPORT_NAME = 'Password Grant Client';

    const RECEIVE_SMS_BODY = ['1401', 'RACE', 'GIFT'];

    const ALL_SLUGS = [

        self::RECEIVE_SMS_BODY,
        self::EMAIL,
        self::PASSWORD,
        self::PASSWORD_CONFIRMATION,
        self::SUBJECT,
        self::MESSAGE,
        self::PHONE,
        self::USERID,
        self::DATE,
        self::PERSONNEL_CODE,
        self::UNIT,
        self::PROFILE,
        self::API_ROUTE,
        self::ROUTE,
        self::USERNAME,
        self::TOKEN,
        self::CODE,
        self::PASSPORT_NAME,
        self::RECEIVE_SMS_BODY,
    ];
}
