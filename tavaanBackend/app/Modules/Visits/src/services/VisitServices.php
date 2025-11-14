<?php

namespace App\Modules\Visits\src\services;

use App\Modules\Visits\src\Models\Visits;
use App\Modules\Visits\src\traits\ExcelTrait;
use Carbon\Carbon;
use holoo\modules\Bases\Helper\Responses;
use holoo\modules\Bases\servers\sms\adapter\mediana\MedianaSmsGateway;
use holoo\modules\Visits\Repositories\VisitInteface;

class VisitServices
{
    use  ExcelTrait;

    public function __construct(protected Responses $response, protected VisitInteface $visits, protected MedianaSmsGateway $smsGateway)
    {
    }

    public function getVisitsData($data): \Illuminate\Http\JsonResponse
    {

        if ($reports = $this->visits->paginates(20)) {

            return $this->response->success($reports, trans('validation.success'));
        }
        return $this->response->notFound('', trans('validation.notFound'));
    }

    public function createVisiteData($data): true
    {

        return $this->importExcel($data);

    }

    public function serachVisits($data)
    {

        $serachData = $data[0]['data'];
        $query = Visits::query()
            ->when($data, function ($q) use ($serachData) {
                $q->where('fullName', 'like', "%{$serachData}%")
                    ->orWhere('phone', 'like', "%{$serachData}%");
            })->paginate(150);

        if ($query) {
            return $this->response->success([
                 $query ,
            ], trans('validation.success'));
        }
        return $this->response->notFound('', trans('validation.notFound'));

    }

    public function update(array $data)
    {
        $id = $data['id'] ?? null;
        $method = $data['method'] ?? null;
        $companions = $data['companions'] ?? null;
        $has_car = $data['has_car'] ?? null;
        $parameters = [];
        $entry_time = null;
        $exit_time = null;

        $visit = Visits::where('id', $id)->first();

        if (!$visit) {
            return $this->response->notFound('', trans('validation.notFound'));
        }
//
        if ($method === 'entry_time' && empty($visit->entry_time)) {
            $entry_time = Carbon::now();

            $parameters = [
                'code' => '806755',
                'name' => $visit->fullName,
            ];
            $visit->update([
                'companions' => $companions,
                'has_car' => $has_car,
                'entry_time' => $entry_time,
            ]);
        }
        if ($method === 'exit_time' && empty($visit->exit_time)) {
            $exit_time = Carbon::now();
            $parameters = [
                'code' => '806756',
                'name' => $visit->fullName,
            ];
            $visit->update([
                'companions' => $companions,
                'has_car' => $has_car,
                'exit_time' => $exit_time,
            ]);
        }
        if ($parameters && !empty($visit->phone)) {
            $this->smsGateway->sendPattern($visit->phone, $parameters);
        }

        return $this->response->success('', trans('validation.success'));
    }
}
