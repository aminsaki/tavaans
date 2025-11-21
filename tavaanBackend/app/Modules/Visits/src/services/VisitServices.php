<?php

namespace App\Modules\Visits\src\services;

use App\Modules\Visits\src\Models\Visits;
use App\Modules\Visits\src\traits\ExcelTrait;
use Carbon\Carbon;
use holoo\modules\Bases\Helper\Responses;
use holoo\modules\Bases\servers\sms\adapter\mediana\MedianaSmsGateway;
use holoo\modules\Visits\Repositories\VisitInteface;
use holoo\modules\Visits\traits\ReportsTraitExcel;
use Illuminate\Support\Facades\DB;

class VisitServices
{
    use  ExcelTrait ,  ReportsTraitExcel;

    public function __construct(protected Responses $response, protected VisitInteface $visits, protected MedianaSmsGateway $smsGateway)
    {
    }
    public function getVisitsData($data): \Illuminate\Http\JsonResponse
    {

      if($reports = $this->visits->myPaginates(20)) {

            $count = DB::table('visits')
                ->where(['statusSms'=>'true'])
                ->selectRaw('COUNT(has_car) as cars, COUNT(*) as total_visits, SUM(companions) as sum_companions, SUM(1 + companions) as sum_total_with_companions')
                ->first();

            return $this->response->success(
                [$reports, $count],
                trans('validation.success'));
        }
        return $this->response->notFound('', trans('validation.notFound'));
    }

    public function createVisiteData($data): true
    {

        return $this->importExcel($data);

    }

    public function serachVisits($data)
    {
          $request =$data[0]['data'];
         $serachData = $request['searchQuery'];
         $select = $request['select'];
        $query = Visits::query()
            ->where('cat_id',$select)
            ->when($data, function ($q) use ($serachData) {
                $q->where('fullName', 'like', "%{$serachData}%")
                    ->orWhere('phone', 'like', "%{$serachData}%");
            })->paginate(150);

        if ($query) {
            return $this->response->success($query, trans('validation.success'));
        }
        return $this->response->notFound('', trans('validation.notFound'));

    }

    public function update(array $data)
    {
        $id = $data['id'] ?? null;
        $method = $data['method'] ?? null;
        $companions = $data['companions'] ?? null;
        $has_car = $data['has_car'] ?? null;
        $command = $data['command'] ?? null;
        $parameters = [];
        $entry_time = Carbon::now();
        $exit_time = Carbon::now();

        $visit = Visits::where('id', $id)->first();

        if (!$visit) {
            return $this->response->notFound('', trans('validation.notFound'));
        }
              $parameters = [
                'code' => '806755',
                'name' => $visit->fullName,
            ];

//
        if ($method === 'entry_time' && empty($visit->entry_time)) {


            $visit->update([
                'companions' => $companions,
                'has_car' => $has_car,
                'entry_time' => $entry_time,
                'command' => $command,
                'statusSms' => 'true'
            ]);
        }
        if ($method === 'exit_time' && empty($visit->exit_time)) {

//
//            $visit->update([
//                'companions' => $companions,
//                'has_car' => $has_car,
//                'exit_time' => $exit_time,
//                'command' => $command,
//            ]);
        }
        if ($parameters && !empty($visit->phone)) {
            $this->smsGateway->sendPattern($visit->phone, $parameters);
        }

//        return $this->response->success('', trans('validation.success'));
    }
     public function excels(): \Illuminate\Http\JsonResponse
     {
        return   $this->exportExcel(Visits::all());
     }
}
