<?php

namespace holoo\modules\Authentications\servers;

use App\Modules\Authentications\src\Repositories\AuthsInterface;
use holoo\modules\Authentications\Traits\OtpTrait;
use holoo\modules\Bases\Helper\Responses;
use holoo\modules\Bases\servers\sms\SmsInterface;
use Illuminate\Support\Facades\Log;

class AuthenticationService
{
    use OtpTrait;

    public function __construct(public AuthsInterface $authentication, public SmsInterface $sms, public Responses $responses)
    {
    }

    public function requestOtp($request)
    {
        $mobile = $request['mobile'];
        $user = $this->authentication->firstWhereModle(['mobile' => $mobile]);

        if (!$user) {
            return $this->responses->notFound('', trans('validation.Otp_search'));
        }

        $codeRandom = generateCodeRandom();

        $text = 'کد تایید:' . $codeRandom . PHP_EOL . ' گروه فناوری اطلاعات';
        $result = $this->sms->send($mobile, $text);
        Log::info('send sms', ['result' => $mobile, $codeRandom]);
        $this->setCacheAddMinutes($codeRandom, 'otp_code', $codeRandom, 'getUser', $user);
        return $this->responses->success('', trans('validation.success'));


    }

    public function verifyOtp($request)
    {
        $code = $request['code'];
        $otpCode = $this->getCache('otp_code', $code);

        if (!$otpCode) {
            return  $this->responses->notFound('', trans('validation.opt_code_expirt'));
        }
        if ($otpCode != $code) {
            return $this->responses->notFound('', trans('validation.errOtp'));
        }
        return $this->authentication->loginUser($request);
    }
}
