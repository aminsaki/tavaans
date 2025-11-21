<?php

namespace holoo\modules\Config\services;

use App\Modules\Visits\src\Models\Visits;
use Carbon\Carbon;
use holoo\modules\Bases\Helper\Responses;
use holoo\modules\Bases\servers\sms\adapter\mediana\MedianaSmsGateway;
use holoo\modules\Config\Models\Config;
use holoo\modules\Config\Repositories\ConfigInteface;
use Illuminate\Support\Facades\DB;

class ConfigServices
{

    public function __construct(protected Responses $response, protected ConfigInteface $conifg, protected MedianaSmsGateway $smsGateway)
    {
    }

    public function getConfigData($data): \Illuminate\Http\JsonResponse
    {
      if($reports = $this->conifg->all()) {

            return $this->response->success(
               $reports,
                trans('validation.success'));
        }
        return $this->response->notFound('', trans('validation.notFound'));
    }

    public function createConfigeData($data): \Illuminate\Http\JsonResponse
    {
           if($this->conifg->create($data)) {

            return $this->response->success(
               '',
                trans('validation.success'));
        }
        return $this->response->notFound('', trans('validation.notFound'));

    }

     public function deleteConfigeData($id): \Illuminate\Http\JsonResponse
     {
            if( $this->conifg->delete($id)) {
            return $this->response->success(
               '',
                trans('validation.success'));
        }
        return $this->response->notFound('', trans('validation.notFound'));
    }
}
