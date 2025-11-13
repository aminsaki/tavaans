<?php

namespace holoo\modules\Bases\Models\Schemas\Constants;

class BaseConstants
{
    const ACTIVE_STATUS = 1;

    const DEFAULT_USER = 1;

    const IS_ACTIVE = 'is_active';

    const UNIQUE_Id = 'unique_id';

    const LIMIT = 10;

    const STR_RANDOM = 10;

    const PHONE_PREFIX = '09';

    const COUNTER_ID = 'counter_id';

    const  NAME = 'name';

    const  SUPER_ADMIN = 'checkRole';

    const  SUPER_ADMIN_ROLE = 'superAdmin';

    const  LASTNAME = 'last_name';
    const  FIRSTNAME = 'last_name';

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
        self::ACTIVE_STATUS,
        self::COUNTER_ID,
        self::IS_ACTIVE,
        self::UNIQUE_Id,
        self::PHONE_PREFIX,
        self::NAME,
        self::SUPER_ADMIN,
        self::SUPER_ADMIN_ROLE,
        self::RECEIVE_SMS_BODY,
        self::LASTNAME,
        self::EMAIL,
        self::PASSWORD,
        self::PASSWORD_CONFIRMATION,
        self::DEFAULT_USER,
        self::SUBJECT,
        self::MESSAGE,
        self::PHONE,
        self::LIMIT,
        self::USERID,
        self::DATE,
        self::PERSONNEL_CODE,
        self::UNIT,
        self::FIRSTNAME,
        self::PROFILE,
        self::API_ROUTE,
        self::ROUTE,
        self::USERNAME,
        self::TOKEN,
        self::CODE,
        self::STR_RANDOM,
        self::PASSPORT_NAME,
        self::RECEIVE_SMS_BODY,
    ];
}
