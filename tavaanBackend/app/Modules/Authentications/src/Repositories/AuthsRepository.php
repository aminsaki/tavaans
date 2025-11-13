<?php

namespace App\Modules\Authentications\src\Repositories;

use App\Models\User;
use holoo\modules\Bases\Helper\Responses;
use holoo\modules\Bases\Http\Contracts\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthsRepository extends BaseRepository implements AuthsInterface
{
    public function model(): mixed
    {
        return User::class;
    }

    public function loginUser($data): mixed
    {
        Log::info('loginAgent', ['data' => $data]);

        if (Auth::attempt(['mobile' => $data['mobile'], 'password' => $data['mobile']], true)) {

            $token = Auth::user()->createToken('Holoo API')->accessToken;

            return Responses::create()->successLogin([
                'list' => $this->firstWhereModle(['id' => Auth::id()], 'roles'),
                'access_token' => 'Bearer ' . $token,
                'token_type' => 'Bearer',
            ], trans('auth.success-message'), 'Bearer ' . $token);
        }

        return Responses::create()->notFound('', trans('auth.account-not-found'));
    }


}
