<?php

namespace App\Modules\Visits\src\services;

use App\Modules\Visits\src\Models\Visits;
use App\Modules\Visits\src\traits\ExcelTrait;
use Carbon\Carbon;
use holoo\modules\Bases\Helper\Responses;
use holoo\modules\Visits\Repositories\VisitInteface;

class VisitServices
{
    use  ExcelTrait;

    public function __construct(protected Responses $response, protected VisitInteface $visits)
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
            return $this->response->success($query, trans('validation.success'));
        }
        return $this->response->notFound('', trans('validation.notFound'));

    }

    public function update($data)
    {
        $id = $data['id'];
        $method = $data['method'];
        $companions = $data['companions'];
        $has_car = !empty($data['has_car']) ? $data['has_car'] : "";

        $entry_time = ($data['method'] === 'entry_time') ? Carbon::now() : "";
        $exit_time = ($data['method'] === 'exit_time') ? Carbon::now() : "";

        $result = Visits::where('id', '=', $id)->first();
        if ($result) {
            $result->update(['companions' => $companions, 'has_car' => $has_car, 'entry_time' => $entry_time, 'exit_time' => $exit_time]);
            return $this->response->success('', trans('validation.success'));
        }
        return $this->response->notFound('', trans('validation.notFound'));

    }
}
