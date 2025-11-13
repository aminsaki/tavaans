<?php

namespace holoo\modules\Bases\Helper;

use holoo\modules\settings\Models\Setting;
use Illuminate\Support\Facades\Auth;

class myAuth
{
    public static function create(): myAuth
    {
        return new self();
    }

    /**
     * get Id USER lOGIN
     *
     * @return mixed
     */
    public function getId()
    {
        return  Auth::id();
    }

    public function getUser()
    {
        return Auth::user();
    }

    /**
     * code users  in   examination test
     */
    public function createTokenUser(): ?string
    {
        $user = \auth('api')->user();
        if ($user) {
            return myAuth . phprand(1, 10000) . $user->id;
        }

        return myAuth . phprand(1, 10000) . rand(1, 100);
    }

    public function myCount($num1, $num2)
    {
        $result = $num1 * $num2;

        return (int) $result;
    }

    public function getSettings($id = 1)
    {
        return Setting::find($id);
    }

}
