<?php

namespace holoo\modules\Bases\servers\webServers\adpter;

use App\Modules\Smss\src\Jobs\SendSmsPaymentJob;
use holoo\modules\Bases\Helper\Responses;
use holoo\modules\Bases\servers\webServers\ClientWordPressInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClientWordPress implements ClientWordPressInterface
{
    public function __construct(protected Responses $responses )
    {
    }

    public function request(...$data): mixed
    {

         $mobile = $data[0]['mobile'];
        try {
            DB::connection('mysqlTwo')->beginTransaction();

            $result = DB::connection('mysqlTwo')
                ->table('wp_usermeta')
                ->where('meta_key', 'digits_phone')
                ->where('meta_value', $mobile)
                ->first();

            if (!$result) {
                if (empty($data[0]['firstName']) || empty($data[0]['lastName']) || empty($mobile)) {
                    return $this->responses->notFound('', trans('validation.usernames_wordpres'));
                }

                $userId = DB::connection('mysqlTwo')->table('wp_users')->insertGetId([
                    'user_login' => $mobile,
                    'display_name' => $data[0]['firstName'] . ' ' . $data[0]['lastName'],
                    'user_nicename' => $mobile,
                    'user_registered' => now(),
                    'user_email' => $data[0]['firstName'] . ' ' . $data[0]['lastName'] . "@gmail.com",
                    'user_pass' => password_hash($mobile, PASSWORD_DEFAULT),
                ]);

                if (!$userId) {
                    return $this->responses->server_error('', trans('validation.usernames_wordpres'));
                }

                $userMetaData = [
                    ['user_id' => $userId, 'meta_key' => 'first_name', 'meta_value' => $data[0]['firstName']],
                    ['user_id' => $userId, 'meta_key' => 'last_name', 'meta_value' => $data[0]['lastName']],
                    ['user_id' => $userId, 'meta_key' => 'digits_phone', 'meta_value' => preg_replace('/^(\+98|98)/', '', ltrim($mobile, '0'))],
                    ['user_id' => $userId, 'meta_key' => 'digits_phone_no', 'meta_value' => $mobile],
                ];
                 DB::connection('mysqlTwo')->table('wp_usermeta')->insert($userMetaData);
//                 SendSmsPaymentJob::dispatchSync($mobile, 'لینک پرداخت و حساب شما در هلو استور فعال شد' . PHP_EOL . 'گروه فناوری اطلاعات هلو');
            }

            DB::connection('mysqlTwo')->commit();
            return true;

        } catch (\Exception $e) {
            DB::connection('mysqlTwo')->rollBack();
            Log::error('Error in request: ' . $e->getMessage(), [
                'data' => $data,
            ]);
            return 'خطایی رخ داده است: ' . $e->getMessage();
        }
    }

}


